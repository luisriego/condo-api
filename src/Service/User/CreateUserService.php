<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\User\UserAlreadyExistsException;
use App\Repository\DoctrineUserRepository;

class CreateUserService
{
    public function __construct(private DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(string $name, string $email): User
    {
        if ($this->userRepository->findOneByEmail($email)) {
            throw UserAlreadyExistsException::fromEmail($email);
        }

        $user = new User($name, $email);
        $this->userRepository->save($user);

        return $user;
    }
}
