<?php

declare(strict_types=1);

namespace App\Trait;

trait CreatedOnTrait
{
    protected \DateTimeImmutable $createdOn;

    public function getCreatedOn(): \DateTimeImmutable
    {
        return $this->createdOn;
    }
}
