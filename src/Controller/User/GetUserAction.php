<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Http\Response\ApiResponse;
use App\Repository\DoctrineUserRepository;
use Symfony\Component\HttpFoundation\Request;

class GetUserAction
{
    public function __construct(private DoctrineUserRepository $userRepository)
    {
    }

    public function __invoke(): ApiResponse
    {
        $users = $this->userRepository->all();

        return new ApiResponse($users);
    }
}