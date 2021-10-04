<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use App\Http\Response\ApiResponse;
use App\Service\User\GetUserByIdService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetUserByIdAction extends ApiController
{
    public function __construct(private GetUserByIdService $getUserByIdService)
    {
    }

    public function __invoke(Request $request, string $id): ApiResponse
    {
        $user = $this->getUserByIdService->__invoke($id);

        $this->denyAccessUnlessGranted('USER_READ', $user);

        return $this->createResponse($user->toArray());
    }
}
