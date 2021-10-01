<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Http\DTO\ChangePasswordRequest;
use App\Http\Response\ApiResponse;
use App\Service\User\ChangePasswordService;
use Symfony\Component\HttpFoundation\Request;

class ChangePasswordAction
{
    public function __construct(private ChangePasswordService $changePasswordService)
    {
    }

    public function __invoke(ChangePasswordRequest $request): ApiResponse
    {
        $this->changePasswordService->__invoke($request->getOldPass(), $request->getNewPass());

        return new ApiResponse([]);
    }
}