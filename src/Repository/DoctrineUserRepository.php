<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\User\UserNotFoundException;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class DoctrineUserRepository extends DoctrineBaseRepository
{
    protected static function entityClass(): string
    {
        return User::class;
    }

    /**
     * @return User[]
     */
    public function all(): array
    {
        return $this->objectRepository->findAll();
    }

    public function updateAllWithIterable()
    {
        $batchSize = 100;
        $i = 1;

        $query = $this->getEntityManager()->createQuery('SELECT u FROM App\Entity\User u');

        foreach ($query->toIterable() as $user) {
            $user->updateScore();

            ++$i;
            if (($i % $batchSize) === 0) {
                $this->getEntityManager()->flush(); // Executes all updates.
                $this->getEntityManager()->clear(); // Detaches all objects from Doctrine!
            }
        }
        $this->getEntityManager()->flush();
    }

    public function findOneById(string $id): ?User
    {
        return $this->objectRepository->find($id);
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->objectRepository->findOneBy(['email' => $email]);
    }

    public function findOneByEmailOrFail(string $email): ?User
    {
        if (null === $user = $this->objectRepository->findOneBy(['email' => $email, 'isActive' => true])) {
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }

    public function findOneByIdWithQueryBuilder(string $id): ?User
    {
        $qb = $this->objectRepository->createQueryBuilder('u');
        $query = $qb
            ->where(
                $qb->expr()->eq('u.id', ':id')
            )
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByIdWithDQL(string $id): ?User
    {
        $query = $this->getEntityManager()->createQuery('SELECT u FROM App\Entity\User u WHERE u.id = :id');
        $query->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByEmailAndToken(string $email, string $token): ?User
    {
        $query = $this->getEntityManager()->createQuery('SELECT u FROM App\Entity\User u WHERE (u.email = :email AND u.token = :token)');
        $query->setParameter('email', $email);
        $query->setParameter('token', $token);

        return $query->getOneOrNullResult();
    }

    public function findOneInactiveByEmailAndTokenOrFail(string $email, string $token): User
    {
        if (null === $user = $this->objectRepository->findOneBy(['email' => $email, 'token' => $token, 'isActive' => false])) {
            throw UserNotFoundException::fromEmailAndToken($email, $token);
        }

        return $user;
    }

    public function findOnyByIdWithNativeQuery(string $id): ?User
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(User::class, 'u');

        $query = $this->getEntityManager()->createNativeQuery('SELECT * FROM user WHERE id = :id', $rsm);
        $query->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

    public function findOneByIdWithPlainSQL(string $id): array
    {
        $params = [
            ':id' => $this->getEntityManager()->getConnection()->quote($id),
        ];
        $query = 'SELECT * FROM user WHERE id = :id';

        return $this->getEntityManager()->getConnection()->executeQuery(\strtr($query, $params))->fetchAllAssociative();
    }

    public function save(User $user): void
    {
        $this->saveEntity($user);
    }

    public function remove(User $user): void
    {
        $this->removeEntity($user);
    }
}
