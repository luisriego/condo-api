<?php

declare(strict_types=1);

namespace App\Tests\Functional\Account;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateAccountActionTest extends AccountTestBase
{
    /**
     * @throws DBALException
     */
    public function testUpdateAccount(): void
    {
        $payload = [
            'name' => 'Conta Corrente do Condominio'
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoAccountId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertEquals('Conta Corrente do Condominio', $responseData[0]['name']);
    }

    /**
     * @throws DBALException
     */
    public function testUpdateAccountFailWithoutName(): void
    {
        $payload = [
            'name' => null
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoAccountId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testUpdateAccountFailWithTooShortName(): void
    {
        $payload = [
            'name' => 'aa'
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoAccountId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}