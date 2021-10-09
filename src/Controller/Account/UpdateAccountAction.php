<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Entity\User;
use App\Http\DTO\UpdateNameRequest;
use App\Http\Response\ApiResponse;
use App\Service\Account\UpdateAccountService;

class UpdateAccountAction
{
    public function __construct(private UpdateAccountService $accountService)
    {
    }

    public function __invoke(UpdateNameRequest $request, string $id, User $user): ApiResponse
    {
        $account = $this->accountService->__invoke($request->getName(), $id, $user);

        return new ApiResponse([$account->toArray()]);
    }
}