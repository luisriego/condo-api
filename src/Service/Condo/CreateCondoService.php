<?php

declare(strict_types=1);

namespace App\Service\Condo;

use App\Entity\Condo;
use App\Entity\User;
use App\Exception\Condo\CondoAlreadyExistsException;
use App\Repository\DoctrineCondoRepository;

class CreateCondoService
{
    public function __construct(
        private DoctrineCondoRepository $condoRepository
    ) {
    }

    public function __invoke(string $cnpj, string $fantasyName, User $user): Condo
    {
        if ($this->condoRepository->findOneByCnpj($cnpj)) {
            throw new CondoAlreadyExistsException(\sprintf('Condo with CNPJ %s already exists', $cnpj));
        }

        $condo = new Condo($cnpj, $fantasyName);
        $condo->addUser($user);
        $this->condoRepository->save($condo);
//        $user->addCondo($condo);
//        $this->userRepository->save($user);

        return $condo;
    }
}
