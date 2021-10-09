<?php

declare(strict_types=1);

namespace App\Exception\Account;

class AccountAlreadyExistsException extends \DomainException
{
    public static function fromName(string $name): self
    {
        throw new self(\sprintf('Account with Name %s already exists', $name));
    }
}
