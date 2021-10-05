<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadAvatarActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/users';

    public function testUploadAvatar(): void
    {
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/avatar.jpg',
            'avatar.jpg'
        );

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s/$s/upload_avatar', self::ENDPOINT, $this->getLuisId()),
            [], ['avatar' => $avatar]
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUploadAvatarWithWrongImputName(): void
    {
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/avatar.jpg',
            'avatar.jpg'
        );

        self::$authenticatedClient->request(
            Request::METHOD_POST,
            \sprintf('%s/$s/upload_avatar', self::ENDPOINT, $this->getLuisId()),
            [], ['invalid-input' => $avatar]
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}