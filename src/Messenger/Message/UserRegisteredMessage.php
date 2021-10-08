<?php

declare(strict_types=1);

namespace App\Messenger\Message;

class UserRegisteredMessage
{
    public function __construct(private string $id, private string $name, private string $email, private string $token)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}