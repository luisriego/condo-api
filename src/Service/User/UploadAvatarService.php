<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Repository\DoctrineUserRepository;
use App\Service\File\FileService;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarService
{
    public const VISIBILITY_PUBLIC = 'public';

    public function __construct(
        private FileService $fileService,
        private DoctrineUserRepository $userRepository,
        private string $mediaPath
    ) { }

    public function uploadAvatar(Request $request, User $user): User
    {
        $file = $this->fileService->validateFile($request, FileService::AVATAR_INPUT_NAME);

        $this->fileService->deleteFile($user->getAvatar());

        $fileName = $this->fileService->uploadFile($file, FileService::AVATAR_INPUT_NAME, self::VISIBILITY_PUBLIC);

        $user->setAvatar($fileName);

        $this->userRepository->save($user);

        return $user;
    }
}