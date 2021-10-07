<?php

declare(strict_types=1);

namespace App\Tests\Functional\Condo;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCondoActionTest extends CondoTestBase
{
    /**
     * @throws DBALException
     */
    public function testUpdateCondo(): void
    {
        $payload = [
            'fantasyName' => 'Condominio do Edifício Matisse'
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertEquals('Condominio do Edifício Matisse', $responseData['fantasyName']);
    }

    public function testUpdateCondoFailNotBelong(): void
    {
        $payload = [
            'fantasyName' => 'Condominio do Edifício Matisse'
        ];

        self::$anotherAuthenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getLuisCondoId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}