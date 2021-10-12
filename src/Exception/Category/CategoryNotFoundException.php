<?php

declare(strict_types=1);

namespace App\Exception\Condo;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryNotFoundException extends NotFoundHttpException
{
    public static function fromName(string $name): self
    {
        throw new self(\sprintf('Category with Name %s not found', $name));
    }

    public static function fromId(string $id): self
    {
        throw new self(\sprintf('Category with Id %s not found', $id));
    }
}
