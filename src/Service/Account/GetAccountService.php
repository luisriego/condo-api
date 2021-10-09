<?php

namespace App\Service\Account;

use App\Entity\Account;
use App\Entity\User;
use App\Exception\Account\AccountNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineAccountRepository;

class GetAccountService
{
    public function __construct(private DoctrineAccountRepository $accountRepository)
    {
    }

    public function __invoke(string $id, User $user): Account
    {
        if (null === $account = $this->accountRepository->findOneByIdOrFail($id)) {
            throw AccountNotFoundException::fromId($id);
        }

        if (!$account->getCondo()->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        return $account;
    }
}