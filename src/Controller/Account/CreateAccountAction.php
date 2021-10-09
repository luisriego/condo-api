<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Entity\User;
use App\Http\DTO\CreateAccountRequest;
use App\Http\Response\ApiResponse;
use App\Service\Account\CreateAccountService;
use Symfony\Component\HttpFoundation\Response;

class CreateAccountAction
{
    private CreateAccountService $accountService;

    public function __construct(CreateAccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function __invoke(CreateAccountRequest $request, User $user): ApiResponse
    {
        $account = $this->accountService->__invoke($request->getName(), $request->getCondoId(), $user);

        return new ApiResponse($account->toArray(), Response::HTTP_CREATED);
    }
}