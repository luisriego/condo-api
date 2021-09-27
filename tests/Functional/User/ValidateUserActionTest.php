<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class testValidateUser extends FunctionalTestBase
{
    private const ENDPOINT_CREATE = '/api/v1/users/create';
    private const ENDPOINT = '/api/v1/users/activate';

    public function testValidateUser(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'juan@api.com'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT_CREATE, [], [], [], \json_encode($payload));
        $response = self::$baseClient->getResponse();
        $responseData = \json_decode($response->getContent(), true);
        $token = $responseData['token'];

        $payload = [
            'email' => 'juan@api.com',
            'token' => $token,
            'password' => 'password'
        ];

        self::$baseClient->request(Request::METHOD_PUT, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertEquals(null, $responseData['token']);
        self::assertEquals(true, $responseData['active']);
    }

    public function testValidateUserFailWithInvalidToken(): void
    {
        $tokenInvalid = 'c55a1f1f9e18fbaeabd98c70c450d6828995a317';

        $payload = [
            'email' => 'juan@api.com',
            'token' => $tokenInvalid,
            'password' => 'password'
        ];

        self::$baseClient->request(Request::METHOD_PUT, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}