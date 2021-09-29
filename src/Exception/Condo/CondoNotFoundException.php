<?php

declare(strict_types=1);

namespace App\Exception\Condo;

class CondoNotFoundException extends \DomainException
{
    public static function fromCnpj(string $cnpj): self
    {
        throw new self(\sprintf('Condo with CNPJ %s not found', $cnpj));
    }

    public static function fromId(string $id): self
    {
        throw new self(\sprintf('Condo with ID %s not found', $id));
    }
}