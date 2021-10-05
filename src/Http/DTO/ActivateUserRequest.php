<?php

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ActivateUserRequest implements RequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 40, max: 40)]
    private ?string $token;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 20)]
    private ?string $password;

    public function __construct(Request $request)
    {
        $this->email = $request->request->get('email');
        $this->token = $request->request->get('token');
        $this->password = $request->request->get('password');
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
