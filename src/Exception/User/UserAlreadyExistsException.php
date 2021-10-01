<?php

declare(strict_types=1);

namespace App\Exception\User;

class UserAlreadyExistsException extends \DomainException
{
    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf('User with email %s already exists', $email));
    }
}
