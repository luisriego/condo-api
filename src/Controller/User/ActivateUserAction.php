<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Http\DTO\ActivateUserRequest;
use App\Service\User\ActivateUserService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ActivateUserAction
{
    public function __construct(private ActivateUserService $activateUserService)
    {
    }

    public function __invoke(ActivateUserRequest $request): JsonResponse
    {
        $user = $this->activateUserService->__invoke($request->getEmail(), $request->getToken(), $request->getPassword());

        return new JsonResponse($user->toArray());
    }
}
