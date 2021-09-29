<?php

declare(strict_types=1);

namespace App\Tests\Functional\Condo;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCondoActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/condos/create';

    public function testCreateCondo(): void
    {
        $payload = [
            'cnpj' => '12345678901234',
            'fantasyName' => 'Condominio Matisse'
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('cnpj', $responseData);
        self::assertArrayHasKey('fantasyName', $responseData);
    }
}