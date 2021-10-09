<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Account;

class DoctrineAccountRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return Account::class;
    }

    public function findOneByIdOrFail(string $id): ?Account
    {
        return $this->objectRepository->findOneBy(['id' => $id]);
    }

    public function findOneByCondoOrFail(string $condoId): ?Account
    {
        return $this->objectRepository->findOneBy(['condoId' => $condoId
        ]);
    }

    public function findOneByNameOrFail(string $condoId, string $name): ?Account
    {
        return $this->objectRepository->findOneBy(['condo' => $condoId, 'name' => $name]);
    }

    public function save(Account $account): void
    {
        $this->saveEntity($account);
    }

    public function remove(Account $account): void
    {
        $this->removeEntity($account);
    }
}
