<?php

declare(strict_types=1);

namespace App\Controller\Movement;

use App\Entity\User;
use App\Http\DTO\UpdateAmountRequest;
use App\Http\Response\ApiResponse;
use App\Service\Movement\UpdateMovementService;

class UpdateMovementAction
{
    public function __construct(private UpdateMovementService $updateMovementService)
    {
    }

    public function __invoke(UpdateAmountRequest $request, string $id, User $user): ApiResponse
    {
        $movement = $this->updateMovementService->__invoke($request->getAmount(), $id, $user);

        return new ApiResponse($movement->toArrayMinimalist());
    }
}