<?php

namespace App\Service\Account;

use App\Entity\User;
use App\Exception\Account\AccountNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineAccountRepository;

class RemoveAccountService
{
    public function __construct(private DoctrineAccountRepository $accountRepository)
    {
    }

    public function __invoke(string $id, User $user)
    {
        if (null === $account = $this->accountRepository->findOneByIdOrFail($id)) {
            throw AccountNotFoundException::fromId($id);
        }

        if (!$account->getCondo()->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        $this->accountRepository->remove($account);
    }
}