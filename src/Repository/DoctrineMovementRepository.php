<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movement;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class DoctrineMovementRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return Movement::class;
    }

    public function findOneByIdOrFail(string $id): ?Movement
    {
        return $this->objectRepository->findOneBy(['id' => $id]);
    }

    public function findOneByCondoOrFail(string $condoId): ?Movement
    {
        return $this->objectRepository->findOneBy(['condoId' => $condoId
        ]);
    }

    public function findOneByNameOrFail(string $name): ?Movement
    {
        return $this->objectRepository->findOneBy(['name' => $name]);
    }

    /**
     * @return Movement[]|null
     */
    public function findAllByIdWithNativeQuery(string $id): ?array
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Movement::class, 'm');

        $query = $this->getEntityManager()->createNativeQuery('SELECT * FROM movement WHERE condo_id = :id', $rsm);
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

    public function save(Movement $movement): void
    {
        $this->saveEntity($movement);
    }

    public function remove(Movement $movement): void
    {
        $this->removeEntity($movement);
    }
}
