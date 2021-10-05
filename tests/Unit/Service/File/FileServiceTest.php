<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\File;

use App\Service\File\FileService;
use League\Flysystem\FilesystemOperator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class FileServiceTest extends TestCase
{
    /** @var FilesystemOperator|MockObject */
    private $storage;

    /** @var LoggerInterface|MockObject */
    private $logger;

    private string $mediaPath;

    private FileService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = $this->getMockBuilder(FilesystemOperator::class)->disableOriginalConstructor()->getMock();
        $this->logger = $this->getMockBuilder(LoggerInterface::class)->disableOriginalConstructor()->getMock();
        $this->mediaPath = 'http://storage.com/';
        $this->service = new FileService($this->storage, $this->logger, $this->mediaPath);
    }

    public function testUploadFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $uploadedFile->method('getPathname')->willReturn('/tmp');
        $uploadedFile->method('guessExtension')->willReturn('jpg');
        $prefix = 'avatar';
        $visibility = 'public';

        $response = $this->service->uploadFile($uploadedFile, $prefix, $visibility);
        $this->assertIsString($response);
    }

    public function testValidateFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $request = new Request([],[],[],[],['avatar' => $uploadedFile]);

        $response = $this->service->validateFile($request, FileService::AVATAR_INPUT_NAME);
        $this->assertInstanceOf(UploadedFile::class, $response);
    }

    public function testDeleteFile(): void
    {
        $path = \sprintf('%s%s', $this->mediaPath, 'avatar/my-avatar.jpg');

        $this->storage
            ->expects($this->exactly(1))
            ->method('delete')
            ->with($path);

        $this->service->deleteFile($path);
    }
}