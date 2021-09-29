<?php

declare(strict_types=1);

namespace App\Exception\Condo;

class CondoAlreadyExistsException extends \DomainException
{
    public static function fromCnpj(string $cnpj): self
    {
        throw new self(\sprintf('Condo with CNPJ %s already exists', $cnpj));
    }
}