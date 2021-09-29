<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class User implements UserInterface
{
    use IdentifierTrait, TimestampableTrait, IsActiveTrait;

    private string $name;
    private string $email;
    private ?string $token;
    private ?string $password;
    private Collection $condos;

    public function __construct(string $name, string $email) 
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->email = $email;
        $this->password = null;
        $this->token = \sha1(\uniqid());
        $this->isActive = false;
        $this->condos = new ArrayCollection();
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getCondos(): ArrayCollection|Collection
    {
        return $this->condos;
    }

    public function addCondo(Condo $condo): void
    {
        if ($this->condos->contains($condo)) {
            return;
        }

        $this->condos->add($condo);
    }

    public function removeCondo(Condo $condo): void
    {
        if ($this->condos->contains($condo)) {
            $this->condos->removeElement($condo);
        }
    }

    public function isMemberOfCondo(Condo $condo): bool
    {
        return $this->condos->contains($condo);
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'email' => "string", 'token' => "string", 'active' => "boolean", 'createdOn' => "string", 'updatedOn' => "string"])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'active' => $this->isActive,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
            'updatedOn' => $this->updatedOn->format(\DateTime::RFC3339),
        ];
    }

//    Implementations

    public function getRoles(): array
    {
        return [];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}
