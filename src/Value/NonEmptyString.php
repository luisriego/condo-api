<?php

declare(strict_types=1);

namespace App\Value;

use JetBrains\PhpStorm\Pure;

class NonEmptyString
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value === '') {
            throw new \DomainException(sprintf("%s is an empty string", $value));
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getValue();
    }
}