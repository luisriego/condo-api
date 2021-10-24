<?php

namespace App\Controller\Account;

use App\Entity\Account;
use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Account\GetAccountsByCondoService;

class GetAccountsByCondoAction
{
    private GetAccountsByCondoService $getAccountsByCondoService;

    public function __construct(GetAccountsByCondoService $getAccountsByCondoService)
    {
        $this->getAccountsByCondoService = $getAccountsByCondoService;
    }

    public function __invoke(string $condoId, User $user): ApiResponse
    {
        /** @var Account[] $accounts */
        $accounts = $this->getAccountsByCondoService->__invoke($condoId, $user);

        $result = array_map(function (Account $account): array {
            return $account->toArrayMinimalist();
        }, $accounts);

        return new ApiResponse(['accounts' => $result]);
    }
}