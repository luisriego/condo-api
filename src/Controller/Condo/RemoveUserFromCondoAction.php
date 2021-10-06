<?php

namespace App\Controller\Condo;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Condo\RemoveUserFromCondoService;

class RemoveUserFromCondoAction
{

    public function __construct(private RemoveUserFromCondoService $removeUserFromCondoService)
    {
    }

    public function __invoke(string $condoId, string $userId, User $userLogged): ApiResponse
    {
        $condo = $this->removeUserFromCondoService->__invoke($condoId, $userId, $userLogged);

        return new ApiResponse($condo->toArray());
    }
}