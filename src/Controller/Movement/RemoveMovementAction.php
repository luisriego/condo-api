<?php

declare(strict_types=1);

namespace App\Controller\Movement;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Movement\RemoveMovementService;
use Symfony\Component\HttpFoundation\Response;

class RemoveMovementAction
{
    public function __construct(private RemoveMovementService $removeMovementService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $this->removeMovementService->__invoke($id, $user);

        return new ApiResponse([],Response::HTTP_NO_CONTENT);
    }
}