<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\TimestampableTrait;
use Symfony\Component\Uid\Uuid;

class Category
{
    public const EXPENSE = 'expense';
    public const INCOME = 'income';

    use IdentifierTrait, TimestampableTrait;

    private string $name;
    private string $type;
    private ?Condo $condo;

    public function __construct(string $name, string $type, ?Condo $condo = null)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->type = $type;
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

    public function getType(): string
    {
        return $this->type;
    }

    public function getCondo(): ?Condo
    {
        return $this->condo;
    }

    public function setCondo(?Condo $condo): void
    {
        $this->condo = $condo;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'condo' => $this->condo->getId(),
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }
}