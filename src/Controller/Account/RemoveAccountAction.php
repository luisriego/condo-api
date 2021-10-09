<?php

namespace App\Controller\Account;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Account\RemoveAccountService;
use Symfony\Component\HttpFoundation\Response;

class RemoveAccountAction
{
    public function __construct(private RemoveAccountService $removeAccountService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $this->removeAccountService->__invoke($id, $user);

        return new ApiResponse([], Response::HTTP_NO_CONTENT);
    }
}