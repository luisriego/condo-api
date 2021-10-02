<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetUsersActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users';

    public function testGetUserById(): void
    {
        self::$authenticatedClient->request(Request::METHOD_GET, \sprintf('%s/%s', self::ENDPOINT, $this->getLuisId()));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('email', $responseData);
        self::assertArrayHasKey('token', $responseData);
    }
}