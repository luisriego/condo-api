<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Entity\Account;
use App\Entity\User;
use App\Exception\Account\AccountAlreadyExistsException;
use App\Exception\Condo\CondoNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineAccountRepository;
use App\Repository\DoctrineCondoRepository;

class CreateAccountService
{
    private DoctrineAccountRepository $accountRepository;
    private DoctrineCondoRepository $condoRepository;

    public function __construct(
        DoctrineAccountRepository $accountRepository,
        DoctrineCondoRepository $condoRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->condoRepository = $condoRepository;
    }

    public function __invoke(string $name, string $condoId, User $user): Account
    {
        if (null === $condo = $this->condoRepository->findOneByIdOrFail($condoId)) {
            throw CondoNotFoundException::fromId($condoId);
        }

        if (!$condo->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        $account = new Account($name, $condo);

        if ($this->accountRepository->findOneByNameOrFail($condoId, $name)) {
            throw AccountAlreadyExistsException::fromName($name);
        }

        $this->accountRepository->save($account);

        return $account;
    }
}