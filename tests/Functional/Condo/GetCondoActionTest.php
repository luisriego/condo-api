<?php

namespace App\Tests\Functional\Condo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetCondoActionTest extends CondoTestBase
{
//    private const ENDPOINT = '/api/v1/condos';

    public function testGetCondosById(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('cnpj', $responseData);
        self::assertArrayHasKey('fantasyName', $responseData);
    }

    public function testGetCondosByIdFailWhenCondoNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, 'condo-not-found-id')
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}