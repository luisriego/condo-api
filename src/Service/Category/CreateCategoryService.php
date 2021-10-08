<?php

declare(strict_types=1);

namespace App\Service\Category;

use App\Entity\Category;
use App\Entity\User;
use App\Exception\Category\CategoryAlreadyExistsException;
use App\Exception\Condo\CondoNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineCategoryRepository;
use App\Repository\DoctrineCondoRepository;

class CreateCategoryService
{
    private DoctrineCategoryRepository $categoryRepository;
    private DoctrineCondoRepository $condoRepository;

    public function __construct(
        DoctrineCategoryRepository $categoryRepository,
        DoctrineCondoRepository $condoRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->condoRepository = $condoRepository;
    }

    public function __invoke(string $name, string $type, string $condoId, User $user): Category
    {
        if (null === $condo = $this->condoRepository->findOneByIdOrFail($condoId)) {
            throw CondoNotFoundException::fromId($condoId);
        }

        if (!$condo->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        $category = new Category($name, $type, $condo);

        if ($this->categoryRepository->findOneByNameAndTypeOrFail($condoId, $name, $type)) {
            throw CategoryAlreadyExistsException::fromNameAndType($name, $type);
        }

        $this->categoryRepository->save($category);

        return $category;
    }
}