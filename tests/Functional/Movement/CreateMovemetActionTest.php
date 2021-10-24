<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateMovemetActionTest extends MovementTestBase

{
    /**
     * @throws DBALException
     */
    public function testCreateMovement(): void
    {
        $payload = [
            'account' => $this->getLuisCondoAccountId(),
            'condo' => $this->getLuisCondoId(),
            'amount' => 37550,
            'category' => $this->getLuisCondoCategoryId(),
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('amount', $responseData);
        self::assertEquals(375.5, $responseData['amount']);
    }

    /**
     * @throws DBALException
     */
    public function testCreateMovementWithoutUser(): void
    {
        $payload = [
            'category' => $this->getLuisCondoCategoryId(),
            'account' => $this->getLuisCondoAccountId(),
            'condo' => $this->getLuisCondoId(),
//            'user' => $this->getLuisId(),
            'amount' => 37550,
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateMovementFailBecauseUnauthorizeUser(): void
    {
        $payload = [
            'category' => $this->getLuisCondoCategoryId(),
            'account' => $this->getLuisCondoAccountId(),
            'condo' => $this->getLuisCondoId(),
            'user' => $this->getLuisId(),
            'amount' => 37550,
        ];

        self::$anotherAuthenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateMovementFailBecauseWithoutCategory(): void
    {
        $payload = [
            'account' => $this->getLuisCondoAccountId(),
            'condo' => $this->getLuisCondoId(),
            'user' => $this->getLuisId(),
            'amount' => 37550,
//            'category' => $this->getLuisCondoCategoryId(),
        ];
        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateMovementFailBecauseWithoutAccount(): void
    {
        $payload = [
            'category' => $this->getLuisCondoCategoryId(),
//            'account' => $this->getLuisCondoAccountId(),
            'condo' => $this->getLuisCondoId(),
            'user' => $this->getLuisId(),
            'amount' => 37550,
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateMovementFailBecauseWithoutCondo(): void
    {
        $payload = [
            'category' => $this->getLuisCondoCategoryId(),
            'account' => $this->getLuisCondoAccountId(),
//            'condo' => $this->getLuisCondoId(),
            'user' => $this->getLuisId(),
            'amount' => 37550,
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateMovementFailBecauseWithoutAmount(): void
    {
        $payload = [
            'category' => $this->getLuisCondoCategoryId(),
            'account' => $this->getLuisCondoAccountId(),
            'condo' => $this->getLuisCondoId(),
            'user' => $this->getLuisId(),
//            'amount' => 37550,
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}