<?php

declare(strict_types=1);

namespace App\Exception\User;

class UserNotFoundException extends \DomainException
{
    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf('User with email %s not found', $email));
    }

    public static function fromId(string $id): self
    {
        throw new self(\sprintf('User with ID %s not found', $id));
    }

    public static function fromEmailAndToken(string $email, string $token): self
    {
        throw new self(\sprintf('User with email %s and token %s not found', $email, $token));
    }
}