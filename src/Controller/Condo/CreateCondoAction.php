<?php

declare(strict_types=1);

namespace App\Controller\Condo;

use App\Http\DTO\CreateCondoRequest;
use App\Service\Condo\CreateCondoService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateCondoAction
{
    public function __construct(private CreateCondoService $createCondoService)
    {
    }

    public function __invoke(CreateCondoRequest $request): JsonResponse
    {
        $condo = $this->createCondoService->__invoke($request->getCnpj(), $request->getFantasyName());

        return new JsonResponse($condo->toArray(), Response::HTTP_CREATED);
    }
}