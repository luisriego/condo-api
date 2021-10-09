<?php

declare(strict_types=1);

namespace App\Exception\Account;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountNotFoundException extends NotFoundHttpException
{
    public static function fromName(string $name): self
    {
        throw new self(\sprintf('Account with Name %s not found', $name));
    }

    public static function fromId(string $id): self
    {
        throw new self(\sprintf('Account with Id %s not found', $id));
    }
}
