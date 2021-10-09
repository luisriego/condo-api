<?php

declare(strict_types=1);

namespace App\Tests\Functional\Account;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveAccountActionTest extends AccountTestBase
{
    /**
     * @throws DBALException
     */
    public function testRemoveAccount(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoAccountId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testRemoveAccountFailBecauseUnauthorize(): void
    {
        self::$anotherAuthenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoAccountId())
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * @throws DBALException
     */
    public function testRemoveAccountFailBecauseAccountNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, 'a-non-existing-account')
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}