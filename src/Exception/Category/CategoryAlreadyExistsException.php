<?php

declare(strict_types=1);

namespace App\Exception\Category;

class CategoryAlreadyExistsException extends \DomainException
{
    public static function fromNameAndType(string $name, string $type): self
    {
        throw new self(\sprintf('Category with Name %s and Type %s already exists', $name, $type));
    }
}
