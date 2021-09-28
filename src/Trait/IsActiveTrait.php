<?php

declare(strict_types=1);

namespace App\Trait;

trait IsActiveTrait
{
    protected bool $isActive;

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function toggleActive(): void
    {
        $this->isActive = !$this->isActive;
    }
}