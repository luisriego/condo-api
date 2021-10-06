<?php

declare(strict_types=1);

namespace App\Exception\Condo;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CondoNotFoundException extends NotFoundHttpException
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
