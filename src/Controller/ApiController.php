<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    public function createResponse(array $data, int $status = JsonResponse::HTTP_OK): ApiResponse
    {
        return new ApiResponse($data, $status);
    }
}
