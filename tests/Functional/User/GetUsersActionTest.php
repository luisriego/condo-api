<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetUsersActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users';

    public function testGetAllUsers(): void
    {
        self::$authenticatedClient->request(Request::METHOD_GET, \sprintf('%s', self::ENDPOINT));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertCount(2, $responseData['users']);
    }

    public function testGetAllUsersFailBecauseUnauthorize(): void
    {
        self::$baseClient->request(Request::METHOD_GET, \sprintf('%s', self::ENDPOINT));

        $response = self::$baseClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}