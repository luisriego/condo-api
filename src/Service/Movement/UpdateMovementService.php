<?php

declare(strict_types=1);

namespace App\Service\Movement;

use App\Entity\Movement;
use App\Entity\User;
use App\Exception\Movement\MovementNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineMovementRepository;

class UpdateMovementService
{
    public function __construct(private DoctrineMovementRepository $movementRepository)
    {
    }

    public function __invoke(int $amount, string $id, User $user): Movement
    {
        if (null === $movement = $this->movementRepository->findOneByIdOrFail($id)) {
            throw MovementNotFoundException::fromId($id);
        }

        if (!$movement->getCondo()->containsUser($user)) {
            throw new UserHasNotAuthorizationException();
        }

        $movement->setAmount($amount);
        $this->movementRepository->save($movement);

        return $movement;
    }
}