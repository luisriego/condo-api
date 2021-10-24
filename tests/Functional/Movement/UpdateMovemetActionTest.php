<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateMovemetActionTest extends MovementTestBase

{
    /**
     * @throws DBALException
     */
    public function testUpdateMovement(): void
    {
        $payload = [
            'amount' => 47550,
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisMovementId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('amount', $responseData);
        self::assertEquals(475.5, $responseData['amount']);
    }

//    /**
//     * @throws DBALException
//     */
//    public function testUpdateMovementWithBadTypeAmountFail(): void
//    {
//        $payload = [
//            'amount' => 'A37550'
//        ];
//
//        self::$authenticatedClient->request(
//            Request::METHOD_PUT,
//            \sprintf('%s/%s', $this->endpoint, $this->getLuisMovementId()),
//            [], [], [],
//            \json_encode($payload)
//        );
//
//        $response = self::$authenticatedClient->getResponse();
//
//        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
//    }

    /**
     * @throws DBALException
     */
    public function testUpdateMovementWithEmptyAmountFail(): void
    {
        $payload = [
            'amount' => null,
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisMovementId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testUpdaateMovementFailBecauseUnauthorizeUser(): void
    {
        $payload = [
            'amount' => 57550,
        ];

        self::$anotherAuthenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisMovementId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}