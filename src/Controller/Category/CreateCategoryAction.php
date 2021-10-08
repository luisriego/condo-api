<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Entity\User;
use App\Http\DTO\CreateCategoryRequest;
use App\Http\Response\ApiResponse;
use App\Service\Category\CreateCategoryService;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryAction
{
    private CreateCategoryService $categoryService;

    public function __construct(CreateCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(CreateCategoryRequest $request, User $user): ApiResponse
    {
        $category = $this->categoryService->__invoke($request->getName(), $request->getType(), $request->getCondoId(), $user);

        return new ApiResponse($category->toArray(), Response::HTTP_CREATED);
    }
}