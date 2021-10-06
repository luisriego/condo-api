<?php

namespace App\Controller\Condo;

use App\Http\Response\ApiResponse;
use App\Service\Condo\RemoveUserFromCondoService;

class RemoveUserFromCondoAction
{

    public function __construct(private RemoveUserFromCondoService $removeUserFromCondoService)
    {
    }

    public function __invoke(string $condoId, string $userId): ApiResponse
    {
        $condo = $this->removeUserFromCondoService->__invoke($condoId, $userId);

        return new ApiResponse($condo->toArray());
    }
}