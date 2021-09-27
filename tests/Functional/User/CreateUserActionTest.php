<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateUserActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users/create';

    public function testCreateUser(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'juan@api.com'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('name', $responseData);
        self::assertArrayHasKey('email', $responseData);
        self::assertArrayHasKey('token', $responseData);
    }

    public function testCreateUserMustHaveAConstrainConflict(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'juan@api.com'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());

    }

     public function testCreateUserWithNoName(): void
     {
         $payload = [
             'email' => 'juan@api.com'
         ];

         self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

         $response = self::$baseClient->getResponse();

         self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
     }

     public function testCreateUserWithNoEmail(): void
     {
         $payload = [
             'name' => 'Juan'
         ];

         self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

         $response = self::$baseClient->getResponse();

         self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
     }

     public function testCreateUserWithInvalidName(): void
     {
         $payload = [
             'name' => 'a',
             'email' => 'juan@api.com'
         ];

         self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

         $response = self::$baseClient->getResponse();

         self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
     }

     public function testCreateUserWithInvalidEmail(): void
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