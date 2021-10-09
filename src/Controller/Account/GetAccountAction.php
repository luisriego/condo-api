<?php

namespace App\Controller\Account;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Account\GetAccountService;

class GetAccountAction
{
    public function __construct(private GetAccountService $getAccountService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $account = $this->getAccountService->__invoke($id, $user);

        return new ApiResponse($account->toArray());
    }
}