<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\NameTrait;
use App\Trait\TimestampableTrait;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Uid\Uuid;

class Movement
{
    use IdentifierTrait, NameTrait, IsActiveTrait, TimestampableTrait;

    private Account $account;
    private Condo $condo;
    private int $amount;
    private ?User $user;
    private ?Category $category;
    private ?string $filePath;

    public function __construct(Account $account, Condo $condo, int $amount, Category $category = null)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->account = $account;
        $this->condo = $condo;
        $this->amount = $amount;
        $this->category = $category;
        $this->user = null;
        $this->name = '';
        $this->filePath = null;
        $this->isActive = true;
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public function getCondo(): Condo
    {
        return $this->condo;
    }

    public function setCondo(Condo $condo): void
    {
        $this->condo = $condo;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function belongsToCondo(Condo $condo): bool
    {
        return $this->condo->getId() === $condo->getId();
    }

    public function toReal(int $amount): string
    {
        $operation = $amount/100;
        return strval($operation);
    }

    #[ArrayShape(['id' => "string", 'category' => "array", 'account' => "array", 'condo' => "array", 'amount' => "int", 'user' => "array", 'createdOn' => "string", 'updatedOn' => "string"])]
    public function toArrayFull(): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category->toArray(),
            'account' => $this->account->toArray(),
            'condo' => $this->condo->toArray(),
            'amount' => $this->toReal($this->amount),
            'user' => $this->user->toArray(),
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category->toArrayMinimalist(),
            'account' => $this->account->toArrayMinimalist(),
            'condo' => $this->condo->toArrayMinimalist(),
            'amount' => $this->toReal($this->amount),
            'user' => $this->user->toArrayMinimalist(),
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }

    public function toArrayMinimalist(): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category->getId(),
            'account' => $this->account->getId(),
            'condo' => $this->condo->getId(),
            'amount' => $this->toReal($this->amount),
            'user' => $this->user->getId()
        ];
    }
}