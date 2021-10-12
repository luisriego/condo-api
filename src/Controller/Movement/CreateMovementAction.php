<?php

declare(strict_types=1);

namespace App\Controller\Movement;

use App\Entity\User;
use App\Http\DTO\CreateMovementRequest;
use App\Http\Response\ApiResponse;
use App\Service\Movement\CreateMovementService;
use Symfony\Component\HttpFoundation\Response;

class CreateMovementAction
{
    public function __construct(private CreateMovementService $createMovementService)
    {
    }

    public function __invoke(CreateMovementRequest $request, User $user): ApiResponse
    {
        $movement = $this->createMovementService->__invoke(
            $request->getCategory(),
            $request->getAccount(),
            $request->getCondo(),
            $user,
            $request->getAmount(),

        );

        return new ApiResponse($movement->toArrayMinimalist(), Response::HTTP_CREATED);
    }
}