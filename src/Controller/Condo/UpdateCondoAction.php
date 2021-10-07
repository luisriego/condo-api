<?php

declare(strict_types=1);

namespace App\Controller\Condo;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Condo\UpdateCondoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateCondoAction
{
    public function __construct(private UpdateCondoService $updateCondoService)
    {
    }

    public function __invoke(Request $request, string $id, User $user): ApiResponse
    {
        $responseData = \json_decode($request->getContent(), true);

        if (null === $name = $responseData['fantasyName']) {
            throw new BadRequestHttpException('The Fantasy Name param is mandatory');
        }

        $condo = $this->updateCondoService->__invoke($name, $id, $user);

        return new ApiResponse($condo->toArray());
    }
}