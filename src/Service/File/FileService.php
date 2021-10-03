<?php

declare(strict_types=1);

namespace App\Service\File;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileService
{
    public const AVATAR_INPUT_NAME = 'avatar';
    public const DOCUMENT_INPUT_NAME = 'document';
    public const MEDIA_INPUT_NAME = 'media';

    public function __construct(private FilesystemOperator $localStorage, private LoggerInterface $logger, string $mediaPath)
    { }

    /**
     * @throws FilesystemException
     */
    public function uploadFile(UploadedFile $file, string $prefix, string $visibility): string
    {
        $fileName = \sprintf('%s/%s.%s', $prefix, \sha1(\uniqid()), $file->guessExtension());

        $this->localStorage->writeStream(
            $fileName,
            \fopen($file->getPathname(), 'r'),
            ['visibility' => $visibility]
        );

        return $fileName;
    }

    public function validateFile(Request $request, string $inputName): UploadedFile
    {
        if (null === $file = $request->files->get($inputName)) {
            throw new BadRequestHttpException(\sprintf('Cannot get file with input name %s', $inputName));
        }

        return $file;
    }

    public function deleteFile(?string $path): void
    {
        try {
            if (null !== $path) {
                $this->localStorage->delete($path);
            }
        } catch (\Exception $e) {
            $this->logger->warning(\sprintf('File %s not found in the storage', $path));
        }
    }
}
