<?php

declare(strict_types=1);

namespace App\Tests\Functional\Account;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateAccountActionTest extends AccountTestBase
{
    /**
     * @throws DBALException
     */
    public function testCreateAccount(): void
    {
        $payload = [
            'name' => 'Energia',
            'condoId' => $this->getLuisCondoId()
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s/create', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('name', $responseData);
    }

    /**
     * @throws DBALException
     */
    public function testCreateAccountFailBecauseUnauthorizeUser(): void
    {
        $payload = [
            'name' => 'Energia',
            'condoId' => $this->getLuisCondoId()
        ];

        self::$anotherAuthenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s/create', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateAccountWithoutName(): void
    {
        $payload = [
//            'name' => 'Energia',
            'condoId' => $this->getLuisCondoId()
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s/create', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateAccountWithTooShortName(): void
    {
        $payload = [
            'name' => 'En',
            'condoId' => $this->getLuisCondoId()
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s/create', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testCreateAccountWithTooShortCondoId(): void
    {
        $payload = [
            'name' => 'Energia',
            'condoId' => '12345678901234567890123456789012345'
        ];

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s/create', $this->endpoint),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}