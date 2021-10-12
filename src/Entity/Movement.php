<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Uid\Uuid;

class Movement
{
    use IdentifierTrait, IsActiveTrait, TimestampableTrait;

    private Category $category;
    private Account $account;
    private Condo $condo;
    private ?User $user;
    private int $amount;
    private ?string $filePath;

    public function __construct(Category $category, Account $account, Condo $condo, int $amount, $user = null)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->category = $category;
        $this->account = $account;
        $this->condo = $condo;
        $this->user = $user;
        $this->amount = $amount;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function isOwnedBy(User $user): bool
    {
        if (null !== $user = $this->user) {
            return $user->getId() === $user->getId();
        }

        return false;
    }

    public function belongsToCondo(Condo $condo): bool
    {
        return $this->condo->getId() === $condo->getId();
    }

    public function toReal(int $amount): string
    {
        return strval($amount/100);
    }

    #[ArrayShape(['id' => "string", 'category' => "array", 'account' => "array", 'condo' => "array", 'amount' => "int", 'user' => "array", 'createdOn' => "string", 'updatedOn' => "string"])]
    public function toArrayFull(): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category->toArray(),
            'account' => $this->account->toArray(),
            'condo' => $this->condo->toArray(),
            'user' => $this->user->toArray(),
            'amount' => $this->amount,
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
            'user' => $this->user->toArrayMinimalist(),
            'amount' => $this->amount,
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
            'user' => $this->user->getId(),
            'amount' => $this->amount,
        ];
    }
}