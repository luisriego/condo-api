<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;

class DoctrineCategoryRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return Category::class;
    }

    public function findOneByIdOrFail(string $id): ?Category
    {
        return $this->objectRepository->findOneBy(['id' => $id]);
    }

    public function findOneByCondoOrFail(string $condoId): ?Category
    {
        return $this->objectRepository->findOneBy(['condoId' => $condoId
        ]);
    }

    public function findOneByNameAndTypeOrFail(string $condoId, string $name, string $type): ?Category
    {
        return $this->objectRepository->findOneBy(['condo' => $condoId, 'name' => $name, 'type' => $type]);
    }

    public function save(Category $category): void
    {
        $this->saveEntity($category);
    }

    public function remove(Category $category): void
    {
        $this->removeEntity($category);
    }
}
