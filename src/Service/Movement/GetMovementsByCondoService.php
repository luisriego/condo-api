<?php

declare(strict_types=1);


namespace App\Service\Movement;

use App\Entity\Movement;
use App\Entity\User;
use App\Exception\Account\AccountNotFoundException;
use App\Exception\Condo\CondoNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineCondoRepository;
use App\Repository\DoctrineMovementRepository;

class GetMovementsByCondoService
{
    public function __construct(
        private DoctrineMovementRepository $movementRepository,
        private DoctrineCondoRepository $condoRepository)
    { }

    /**
     * @return Movement[]
     */
    public function __invoke(string $condoId, User $user): array
    {
        if (null === $condo = $this->condoRepository->findOneByIdOrFail($condoId)) {
            throw CondoNotFoundException::fromId($condoId);
        }

        if (!$condo->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        if (null === $movements = $this->movementRepository->findAllByIdWithNativeQuery($condoId)) {
            throw AccountNotFoundException::fromId($condoId);
        }

        return $movements;
    }
}