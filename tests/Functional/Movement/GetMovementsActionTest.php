<?php

namespace App\Tests\Functional\Movement;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetMovementsActionTest extends MovementTestBase
{
    /**
     * @throws DBALException
     */
    public function testGetMovementsByCondo(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/condo/%s', $this->endpoint, $this->getLuisCondoId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertCount(2, $responseData['movements']);
    }
}