<?php

declare(strict_types=1);

namespace App\Exception\Movement;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovementNotFoundException extends NotFoundHttpException
{
    public static function fromName(string $name): self
    {
        throw new self(\sprintf('Movement with Name %s not found', $name));
    }

    public static function fromId(string $id): self
    {
        throw new self(\sprintf('Movement with Id %s not found', $id));
    }
}
