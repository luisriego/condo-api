<?php

declare(strict_types=1);

namespace App\Controller\Condo;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Condo\GetCondoByIdService;

class GetCondoByIdAction
{
    public function __construct(private GetCondoByIdService $getCondoByIdService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $condo = $this->getCondoByIdService->__invoke($id, $user);

        return new ApiResponse($condo->toArray());
    }
}
