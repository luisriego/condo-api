<?php

declare(strict_types=1);

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterAction
{
    public function __invoke(Request $request): JsonResponse
    {
        
        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
}
