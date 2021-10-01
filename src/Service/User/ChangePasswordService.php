<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Repository\DoctrineUserRepository;

class ChangePasswordService
{
    public function __construct(private DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(string $oldPass, string $newPass): void
    {
        // TODO: Implement __invoke() method.
    }
}