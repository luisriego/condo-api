<?php

declare(strict_types=1);

namespace App\Tests\Functional\Category;

use App\Entity\Category;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryActionTest extends CategoryTestBase
{
    /**
     * @throws DBALException
     */
    public function testUpdateCondo(): void
    {
        $payload = [
            'name' => 'Energia',
            'type' => Category::EXPENSE,
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
        self::assertEquals('expense', $responseData['type']);
    }

    /**
     * @throws DBALException
     */
    public function testUpdateCondoFailBecauseUnauthorizeUser(): void
    {
        $payload = [
            'name' => 'Energia',
            'type' => Category::EXPENSE,
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
    public function testUpdateCondoWithoutName(): void
    {
        $payload = [
//            'name' => 'Energia',
            'type' => Category::EXPENSE,
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
    public function testUpdateCondoWithTooShortName(): void
    {
        $payload = [
            'name' => 'En',
            'type' => Category::EXPENSE,
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
    public function testUpdateCondoWithWrongType(): void
    {
        $payload = [
            'name' => 'Energia',
            'type' => 'wrong-type',
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
    public function testUpdateCondoWithTooShortCondoId(): void
    {
        $payload = [
            'name' => 'Energia',
            'type' => Category::EXPENSE,
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