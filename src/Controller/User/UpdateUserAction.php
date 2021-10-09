<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Http\DTO\UpdateNameRequest;
use App\Http\Response\ApiResponse;
use App\Service\User\UpdateUserService;

class UpdateUserAction
{
    public function __construct(private UpdateUserService $updateUserService)
    {
    }

    public function __invoke(UpdateNameRequest $request, string $id): ApiResponse
    {
        $user = $this->updateUserService->__invoke($id, $request->getName());

        return new ApiResponse($user->toArray());
    }
}
