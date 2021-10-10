<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\TimestampableTrait;
use Symfony\Component\Uid\Uuid;

class Account
{
    use IdentifierTrait, TimestampableTrait;

    private string $name;
    private ?Condo $condo;

    /**
     * @param string $name
     * @param Condo|null $condo
     */
    public function __construct(string $name, ?Condo $condo = null)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->condo = $condo;
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCondo(): ?Condo
    {
        return $this->condo;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'condo' => $this->condo->getId(),
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }

    public function toSimpleArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'condo' => $this->condo->getId(),
        ];
    }
}