<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Entity\Account;
use App\Entity\User;
use App\Exception\Account\AccountNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineAccountRepository;

class UpdateAccountService
{
    public function __construct(private DoctrineAccountRepository $accountRepository)
    {
    }

    public function __invoke(string $name, string $id, User $user): Account
    {
        if (null === $account = $this->accountRepository->findOneByIdOrFail($id)) {
            throw AccountNotFoundException::fromId($id);
        }

        if (!$account->getCondo()->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        $account->setName($name);
        $this->accountRepository->save($account);

        return $account;
    }
}