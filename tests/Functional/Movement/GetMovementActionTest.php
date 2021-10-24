<?php

namespace App\Tests\Functional\Movement;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetMovementActionTest extends MovementTestBase
{
    /**
     * @throws DBALException
     */
    public function testGetMovement(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisMovementId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('amount', $responseData);
        self::assertEquals(1234.56, $responseData['amount']);
    }
}