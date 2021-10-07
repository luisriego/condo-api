<?php

declare(strict_types=1);

namespace App\Tests\Functional\Condo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveUserFromCondoActionTest extends CondoTestBase
{
    public function testRemoveUserFromCondosById(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s/user/%s', $this->endpoint, $this->getLuisCondoId(), $this->getLuisId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertCount(0, $responseData['users']);
    }

    public function testRemoveUserFromCondosByIdFailCondoNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s/user/%s', $this->endpoint, 'wrong-condo-id', $this->getAnotherId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testRemoveUserFromCondosByIdFailUserNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s/user/%s', $this->endpoint, $this->getLuisCondoId(), 'wrong_id')
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}