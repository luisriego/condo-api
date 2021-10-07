<?php

declare(strict_types=1);

namespace App\Doctrine\Extension;

use App\Entity\Condo;
use App\Entity\User;
use App\Repository\DoctrineCondoRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CurrentUserExtension
{
//    public function __construct(TokenStorageInterface $tokenStorage, DoctrineCondoRepository $condoRepository)
//    {  }
//
//    public function applyToCollection(
//        QueryBuilder $queryBuilder,
//        string $resourceClass,
//        string $operationName = null
//    ) {
//        $this->addWhere($queryBuilder, $resourceClass);
//    }
//
//    private function addWhere(QueryBuilder $qb, string $resourceClass): void
//    {
//        /** @var User|null $user */
//        $user = $this->tokenStorage->getToken()
//            ? $this->tokenStorage->getToken()->getUser()
//            : null;
//
//        $rootAlias = $qb->getRootAliases()[0];
//
//        if (Condo::class === $resourceClass) {
//            if ($qb->getParameters()->first()->getValue() !== $user->getId()) {
//                throw new AccessDeniedHttpException('You can\'t retrieve another user condo');
//            }
//        }
//
//        if (User::class === $resourceClass) {
//            foreach ($user->getCondos() as $condos) {
//                if ($condos->getId() === $qb->getParameters()->first()->getValue()) {
//                    return;
//                }
//            }
//
//            throw new AccessDeniedHttpException('You can\'t retrieve users of another group');
//        }

//        if (\in_array($resourceClass, [Category::class, Movement::class])) {
//            $parameterId = $qb->getParameters()->first()->getValue();
//
//            if ($this->isGroupAndUserIsMember($parameterId, $user)) {
//                $qb->andWhere(\sprintf('%s.group = :parameterId', $rootAlias));
//                $qb->setParameter('parameterId', $parameterId);
//            } else {
//                $qb->andWhere(\sprintf('%s.%s = :user', $rootAlias, $this->getResources()[$resourceClass]));
//                $qb->andWhere(\sprintf('%s.group IS NULL', $rootAlias));
//                $qb->setParameter('user', $user);
//            }
//        }
//    }
}