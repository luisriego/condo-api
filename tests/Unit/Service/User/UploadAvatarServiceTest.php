<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Service\File\FileService;
use App\Service\User\UploadAvatarService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarServiceTest extends UserServiceTestBase
{
    private string $mediaPath;

    /** FileService|MockObject */
    private $fileService;


    private UploadAvatarService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileService = $this->getMockBuilder(FileService::class)->disableOriginalConstructor()->getMock();
        $this->mediaPath = 'http://storage.com/';
        $this->service = new UploadAvatarService($this->fileService, $this->userRepository, $this->mediaPath);
    }

    public function testUploadAvatar():void
    {
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $file = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $user = new User('name', 'name@api.com');
        $user->setAvatar('my-avatar.jpg');

        $this->fileService
            ->expects($this->exactly(1))
            ->method('validateFile')
            ->with($request, FileService::AVATAR_INPUT_NAME)
            ->willReturn($file);

        $this->fileService
            ->expects($this->exactly(1))
            ->method('deleteFile')
            ->with($user->getAvatar());

        $this->fileService
            ->expects($this->exactly(1))
            ->method('uploadFile')
            ->with($file, FileService::AVATAR_INPUT_NAME)
            ->willReturn('my-avatar.jpg');

        $response = $this->service->uploadAvatar($request, $user);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals('my-avatar.jpg', $response->getAvatar());
    }
}