<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\User\UploadAvatarService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadAvatar
{
    public function __construct(private UploadAvatarService $uploadAvatarService)
    { }

    public function __invoke(Request $request, User $user): ApiResponse
    {
        $user = $this->uploadAvatarService->uploadAvatar($request, $user);

        return new ApiResponse($user->toArray(), Response::HTTP_CREATED);
    }
}