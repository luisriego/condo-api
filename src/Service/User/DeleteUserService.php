<?php

namespace App\Service\User;

use App\Exception\User\UserNotFoundException;
use App\Repository\DoctrineUserRepository;

class DeleteUserService
{
    public function __construct(private DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(string $id): void
    {
        if (null === $user = $this->userRepository->findOneByIdOrFail($id)) {
            throw UserNotFoundException::fromId($id);
        }

        $this->userRepository->remove($user);
    }
}