<?php

declare(strict_types=1);

namespace App\Controller\Movement;

use App\Entity\Movement;
use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Movement\GetMovementsByCondoService;

class GetMovementsByCondoAction
{
    public function __construct(private GetMovementsByCondoService $getMovementsByCondoService)
    { }

    public function __invoke(string $condoId, User $user): ApiResponse
    {
        $movements = $this->getMovementsByCondoService->__invoke($condoId, $user);

        $result = array_map(function (Movement $movement): array {
            return $movement->toArrayMinimalist();
        }, $movements);

        return new ApiResponse(['movements' => $result, 'found' => count($movements)]);
    }
}