<?php

declare(strict_types=1);

namespace App\Service\Condo;

use App\Entity\Condo;
use App\Entity\User;
use App\Exception\Condo\CondoNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineCondoRepository;

class UpdateCondoService
{
    public function __construct(private DoctrineCondoRepository $condoRepository)
    {
    }

    public function __invoke(string $name, string $id, User $user): Condo
    {
        if (null === $condo = $this->condoRepository->findOneByIdIfActive($id)) {
            throw CondoNotFoundException::fromId($id);
        }

        if (!$condo->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        $condo->setFantasyName($name);
        $this->condoRepository->save($condo);

        return $condo;
    }
}
