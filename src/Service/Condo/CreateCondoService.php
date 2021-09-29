<?php

declare(strict_types=1);

namespace App\Service\Condo;


use App\Entity\Condo;
use App\Exception\CondoAlreadyExistsException;
use App\Repository\DoctrineCondoRepository;

class CreateCondoService
{

    public function __construct(private DoctrineCondoRepository $condoRepository)
    {
    }

    public function __invoke(string $cnpj, string $fantasyName): Condo
    {
        $condo = new Condo($cnpj, $fantasyName);
        $condo->toggleActive();
        if ($this->condoRepository->findOneByCnpj($cnpj)) {
            throw new CondoAlreadyExistsException(\sprintf('Condo with CNPJ %s already exists', $cnpj));
        }

        $this->condoRepository->save($condo);

        return $condo;
    }
}