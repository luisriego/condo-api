<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users';

    public function testUpdateUser(): void
    {
        $payload = [
            'name' => 'Jose Luis'
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::ENDPOINT, $this->getLuisId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();
        $responseData = \json_decode($response->getContent(), true);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('Jose Luis', $responseData['name']);
    }

    public function testUpdateUserFailNoName(): void
    {
        $payload = [
            'name' => null
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::ENDPOINT, $this->getLuisId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}