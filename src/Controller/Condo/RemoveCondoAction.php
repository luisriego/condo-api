<?php

namespace App\Controller\Condo;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Condo\RemoveCondoService;
use Symfony\Component\HttpFoundation\Response;

class RemoveCondoAction
{
    public function __construct(private RemoveCondoService $removeCondoService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $this->removeCondoService->__invoke($id, $user);

        return new ApiResponse([], Response::HTTP_NO_CONTENT);
    }
}
