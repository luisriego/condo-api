<?php

namespace App\Controller\Condo;

use App\Http\Response\ApiResponse;
use App\Service\Condo\AddUserToCondoService;

class AddUserToCondoAction
{
    public function __construct(private AddUserToCondoService $addUserToCondoService)
    {
    }

    public function __invoke(string $condoId, string $userId): ApiResponse
    {
        $condo = $this->addUserToCondoService->__invoke($condoId, $userId);

        return new ApiResponse($condo->toArray());
    }
}