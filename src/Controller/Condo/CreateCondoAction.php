<?php

declare(strict_types=1);

namespace App\Controller\Condo;

use App\Entity\Condo;
use App\Repository\DoctrineCondoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCondoAction
{
    public function __construct(private DoctrineCondoRepository $condoRepository)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = \json_decode($request->getContent(), true);

        $condo = new Condo($data['cnpj'], $data['fantasyName']);

        $this->condoRepository->save($condo);

        return new JsonResponse($condo->toArray(), Response::HTTP_CREATED);
    }
}