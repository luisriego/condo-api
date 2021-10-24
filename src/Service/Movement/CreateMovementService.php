<?php

declare(strict_types=1);

namespace App\Service\Movement;

use App\Entity\Movement;
use App\Entity\User;
use App\Exception\Account\AccountNotFoundException;
use App\Exception\Category\CategoryNotFoundException;
use App\Exception\Condo\CondoNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineAccountRepository;
use App\Repository\DoctrineCategoryRepository;
use App\Repository\DoctrineCondoRepository;
use App\Repository\DoctrineMovementRepository;

class CreateMovementService
{
    public function __construct(
        private DoctrineMovementRepository $movementRepository,
        private DoctrineCondoRepository $condoRepository,
        private DoctrineCategoryRepository $categoryRepository,
        private DoctrineAccountRepository $accountRepository
    ) { }

    public function __invoke(string $account_id, string $condo_id, User $user, int $amount, ?string $category_id): Movement
    {
        if (null === $condo = $this->condoRepository->findOneByIdOrFail($condo_id)) {
            throw CondoNotFoundException::fromId($condo_id);
        }

        if (!$condo->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        if (null === $category_id) {
            throw CategoryNotFoundException::nullId();
        }

        if (null === $category = $this->categoryRepository->findOneByIdOrFail($category_id)) {
            throw CategoryNotFoundException::fromId($category_id);
        }

        if (null === $account = $this->accountRepository->findOneByIdOrFail($account_id)) {
            throw AccountNotFoundException::fromId($account_id);
        }

        $movement = new Movement($account, $condo, $amount, $category);
        $movement->setUser($user);
        $this->movementRepository->save($movement);

        return $movement;
    }
}