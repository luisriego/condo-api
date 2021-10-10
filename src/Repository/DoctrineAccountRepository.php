<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Account;
use App\Exception\Account\AccountNotFoundException;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

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

    /**
     * @return Account[]|null
     */
    public function findAllByIdWithNativeQuery(string $id): ?array
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Account::class, 'a');

        $query = $this->getEntityManager()->createNativeQuery('SELECT * FROM account WHERE condo_id = :id', $rsm);
        $query->setParameter('id', $id);

        return $query->getResult();
    }

//    public function findAllByCondoOrFail(string $condoId): ?array
//    {
//        if (null === $accounts = $this->objectRepository->find('condoId', $condoId)) {
//            throw new AccountNotFoundException();
//        }
//
//        return $accounts;
//    }

    public function save(Account $account): void
    {
        $this->saveEntity($account);
    }

    public function remove(Account $account): void
    {
        $this->removeEntity($account);
    }
}
