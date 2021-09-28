<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Http\DTO\CreateUserRequest;
use App\Http\Response\ApiResponse;
use App\Service\User\CreateUserService;
use Symfony\Component\HttpFoundation\Response;

class CreateUserAction
{

    public function __construct(private CreateUserService $createUserService)
    {
    }

    public function __invoke(CreateUserRequest $request): ApiResponse
    {
        $user = $this->createUserService->__invoke($request->getName(), $request->getEmail());

        return new ApiResponse($user->toArray(), Response::HTTP_CREATED);
    }
}
