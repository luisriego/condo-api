<?php

namespace App\Service\Condo;

use App\Entity\Condo;
use App\Exception\Condo\CondoNotFoundException;
use App\Exception\User\UserNotFoundException;
use App\Repository\DoctrineCondoRepository;
use App\Repository\DoctrineUserRepository;

class RemoveUserFromCondoService
{
    public function __construct(
        private DoctrineCondoRepository $condoRepository,
        private DoctrineUserRepository $userRepository
    ) { }

    public function __invoke(string $condoId, string $userId): Condo
    {
        if (null === $condo = $this->condoRepository->findOneByIdIfActive($condoId)) {
            throw CondoNotFoundException::fromId($condoId);
        }

        if (null === $user = $this->userRepository->findOneByIdOrFail($userId)) {
            throw UserNotFoundException::fromId($userId);
        }

        if (!$condo->containsUser($user)) {
            throw UserNotFoundException::fromId($userId);
        }

        $condo->removeUser($user);
        $this->condoRepository->save($condo);

        return $condo;
    }
}