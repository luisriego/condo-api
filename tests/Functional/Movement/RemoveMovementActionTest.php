<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveMovementActionTest extends MovementTestBase

{
    /**
     * @throws DBALException
     */
    public function testUpdateMovement(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisMovementId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testRemoveMovementFailBecauseUnauthorizeUser(): void
    {
        self::$anotherAuthenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisMovementId())
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testRemoveMovementFailBecauseMovementNotExist(): void
    {
        self::$anotherAuthenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, 'a196a8ed-063e-4f61-96e6-16253281b763')
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}