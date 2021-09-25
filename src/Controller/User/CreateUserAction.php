<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\DoctrineUserRepository;
use App\Service\User\CreateUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateUserAction
{

    public function __construct(private CreateUserService $createUserService)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $responseData = \json_decode($request->getContent(), true);

        $user = $this->createUserService->__invoke($responseData['name'], $responseData['email']);

        return new JsonResponse($user->toArray(), Response::HTTP_CREATED);
    }
}
