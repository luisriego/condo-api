<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users';

    public function testDeleteUser(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', self::ENDPOINT, $this->getLuisId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testTryToDeleteAANotExistingUser(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', self::ENDPOINT, 'not-existing-user')
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}