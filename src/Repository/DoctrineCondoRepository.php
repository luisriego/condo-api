<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Condo;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class DoctrineCondoRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return Condo::class;
    }

    public function findOneById(string $id): ?Condo
    {
        return $this->objectRepository->find($id);
    }

//    /**
//     * @throws \Doctrine\ORM\NonUniqueResultException
//     */
//    public function findOneByEmailAndToken(string $email, string $token): ?User
//    {
//        $query = $this->getEntityManager()->createQuery('SELECT u FROM App\Entity\User u WHERE (u.email = :email AND u.token = :token)');
//        $query->setParameter('email', $email);
//        $query->setParameter('token', $token);
//
//        return $query->getOneOrNullResult();
//    }

    public function save(Condo $condo): void
    {
        $this->saveEntity($condo);
    }

    public function remove(Condo $condo): void
    {
        $this->removeEntity($condo);
    }
}