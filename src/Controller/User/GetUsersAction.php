<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Http\Response\ApiResponse;
use App\Repository\DoctrineUserRepository;

class GetUsersAction
{
    public function __construct(private DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(): ApiResponse
    {
        $users = $this->userRepository->all();

        $result = array_map(function (User $user): array {
            return $user->toArray();
        }, $users);

        return new ApiResponse(['users' => $result]);
    }
}
