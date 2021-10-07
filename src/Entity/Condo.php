<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Uid\Uuid;

class Condo
{
    use IdentifierTrait;
    use IsActiveTrait;
    use TimestampableTrait;

    private string $cnpj;
    private string $fantasyName;
    private Collection $users;

    public function __construct(string $cnpj, string $fantasyName)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->cnpj = $cnpj;
        $this->fantasyName = $fantasyName;
        $this->isActive = false;
        $this->users = new ArrayCollection();
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

    public function getUsers(): ArrayCollection | Collection
    {
        return $this->users;
    }

    public function addUser(User $user): void
    {
        if ($this->users->contains($user)) {
            return;
        }

        $this->users->add($user);
    }

    public function removeUser(User $user): void
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }
    }

    public function containsUser(User $user): bool
    {
        return $this->users->contains($user);
    }

    #[ArrayShape(['id' => "string", 'fantasyName' => "string", 'cnpj' => "string", 'active' => "false", 'createdOn' => "string", 'updatedOn' => "string", 'users' => "array[]"])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fantasyName' => $this->fantasyName,
            'cnpj' => $this->cnpj,
            'active' => $this->isActive,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
            'users' => array_map(function (User $user): array {
                return $user->toArray();
            }, $this->users->toArray()),
        ];
    }
}
