<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users';

    public function testChangePassword(): void
    {
        $payload = [
            'oldPass' => 'password',
            'newPass' => 'new-password'
        ];
        $userId = 'b4738965-635c-4f8d-a2dc-6031e633e03e';

        self::$authenticatedClient->request(
            Request::METHOD_PUT, \sprintf('%s/$s/change_password', self::ENDPOINT, $this->getLuisId()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testChangePasswordWithoutAuthMustFail(): void
    {
        $payload = [
            'oldPass' => 'password',
            'newPass' => 'new-password'
        ];
        $userId = '123456';

        self::$baseClient->request(
            Request::METHOD_PUT, \sprintf('%s/$s/change_password', self::ENDPOINT, $userId),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$baseClient->getResponse();

        self::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}