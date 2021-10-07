<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\Http\DTO\ChangePasswordRequest;
use App\Http\Response\ApiResponse;
use App\Service\User\ChangePasswordService;

class ChangePasswordAction
{
    public function __construct(private ChangePasswordService $changePasswordService)
    {
    }

    public function __invoke(ChangePasswordRequest $request, User $user): ApiResponse
    {
        $user = $this->changePasswordService->__invoke($request->getOldPass(), $request->getNewPass(), $user);

        return new ApiResponse($user->toArray());
    }
}
