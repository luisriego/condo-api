<?php

namespace App\Tests\Functional\Account;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetAccountActionTest extends AccountTestBase
{
    /**
     * @throws DBALException
     */
    public function testGetAccount(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoAccountId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertEquals('Conta Condominio', $responseData['name']);
    }

    /**
     * @throws DBALException
     */
    public function testGetAccountFailBecauseAccountNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, 'a-non-existing-account')
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testGetAccountFailBecauseUnauthorizeduser(): void
    {
        self::$anotherAuthenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoAccountId())
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}