<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use Symfony\Component\Uid\Uuid;

class Condo
{
    use IdentifierTrait, IsActiveTrait, TimestampableTrait;

    private string $cnpj;
    private string $fantasyName;

    /**
     * @param string $cnpj
     * @param string $fantasyName
     */
    public function __construct(string $cnpj, string $fantasyName)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->cnpj = $cnpj;
        $this->fantasyName = $fantasyName;
        $this->isActive = false;
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): void
    {
        $this->cnpj = $cnpj;
    }

    public function getFantasyName(): string
    {
        return $this->fantasyName;
    }

    public function setFantasyName(string $fantasyName): void
    {
        $this->fantasyName = $fantasyName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fantasyName' => $this->fantasyName,
            'cnpj' => $this->cnpj,
            'active' => $this->isActive,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }
}