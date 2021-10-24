<?php

declare(strict_types=1);

namespace App\Controller\Movement;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Movement\GetMovementService;

class GetMovementAction
{
    public function __construct(private GetMovementService $getMovementService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $movement = $this->getMovementService->__invoke($id, $user);

        return new ApiResponse($movement->toArrayMinimalist());
    }
}