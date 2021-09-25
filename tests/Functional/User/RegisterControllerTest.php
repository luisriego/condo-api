<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterControllerTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users/create';

    public function testRegisterUser(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'juan@api.com'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('token', $responseData);
    }

    public function testRegisterUserAlreadyExistMustFail(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'juan@api.com'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());

    }

     public function testRegisterUserWithNoName(): void
     {
         $payload = [
             'email' => 'juan@api.com'
         ];

         self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

         $response = self::$baseClient->getResponse();

         self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
     }

     public function testRegisterUserWithNoEmail(): void
     {
         $payload = [
             'name' => 'Juan'
         ];

         self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

         $response = self::$baseClient->getResponse();

         self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
     }

     public function testRegisterUserWithInvalidName(): void
     {
         $payload = [
             'name' => 'a',
             'email' => 'juan@api.com'
         ];

         self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

         $response = self::$baseClient->getResponse();

         self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
     }

     public function testRegisterUserWithInvalidEmail(): void
     {
         $payload = [
             'name' => 'Juan',
             'email' => 'api.com',
             'password' => 'password123'
         ];

         self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

         $response = self::$baseClient->getResponse();

         self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
     }
}