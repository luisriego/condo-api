<?php

namespace App\Controller\User;

use App\Exception\User\UserNotFoundException;
use App\Http\Response\ApiResponse;
use App\Repository\DoctrineUserRepository;
use App\Service\User\UpdateUserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateUserAction
{
    public function __construct(private UpdateUserService $updateUserService)
    {
    }

    public function __invoke(Request $request, string $id): ApiResponse
    {
        $responseData = \json_decode($request->getContent(), true);

        if (null === $name = $responseData['name']) {
            throw new BadRequestHttpException('Name param is mandatory');
        }

        $user = $this->updateUserService->__invoke($id, $name);

        return new ApiResponse($user->toArray());
    }
}