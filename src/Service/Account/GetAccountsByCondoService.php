<?php

namespace App\Service\Account;

use App\Entity\Account;
use App\Entity\User;
use App\Exception\Account\AccountNotFoundException;
use App\Exception\Condo\CondoNotFoundException;
use App\Repository\DoctrineAccountRepository;
use App\Repository\DoctrineCondoRepository;

class GetAccountsByCondoService
{
    private DoctrineAccountRepository $accountRepository;
    private DoctrineCondoRepository $condoRepository;

    public function __construct(DoctrineAccountRepository $accountRepository, DoctrineCondoRepository $condoRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->condoRepository = $condoRepository;
    }

    /**
     * @return Account[]
     */
    public function __invoke(string $condoId, User $user): array
    {
        if (null === $condo = $this->condoRepository->findOneByIdOrFail($condoId)) {
            throw CondoNotFoundException::fromId($condoId);
        }
        if (null === $accounts = $this->accountRepository->findAllByIdWithNativeQuery($condoId)) {
            throw AccountNotFoundException::fromId($condoId);
        }

        return $accounts;
    }

}