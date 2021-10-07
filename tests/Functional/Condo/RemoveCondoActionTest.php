<?php

namespace App\Tests\Functional\Condo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveCondoActionTest extends CondoTestBase
{
    public function testRemoveCondo(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testRemoveCondoFailUnauthorizedUser(): void
    {
        self::$anotherAuthenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoId())
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}