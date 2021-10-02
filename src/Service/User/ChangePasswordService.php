<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Exception\Password\PasswordException;
use App\Repository\DoctrineUserRepository;

class ChangePasswordService
{
    public function __construct(private DoctrineUserRepository $userRepository, private EncodePasswordService $encodePasswordService)
    {
    }

    public function __invoke(string $oldPass, string $newPass, User $user): User
    {
        if (!$this->encodePasswordService->isValidPassword($user, $oldPass)) {
            throw PasswordException::oldPasswordDoesNotMatch();
        }

        $user->setPassword($this->encodePasswordService->generateEncodedPassword($user, $newPass));

        $this->userRepository->save($user);

        return $user;
    }
}