<?php

declare(strict_types=1);

namespace App\Controller\Condo;

use App\Entity\User;
use App\Http\DTO\UpdateFantasyNameRequest;
use App\Http\DTO\UpdateUserRequest;
use App\Http\Response\ApiResponse;
use App\Service\Condo\UpdateCondoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateCondoAction
{
    public function __construct(private UpdateCondoService $updateCondoService)
    {
    }

    public function __invoke(UpdateFantasyNameRequest $request, string $id, User $user): ApiResponse
    {
        $condo = $this->updateCondoService->__invoke($request->getFanatasyName(), $id, $user);

        return new ApiResponse($condo->toArray());
    }
}
