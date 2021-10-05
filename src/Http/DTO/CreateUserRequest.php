<?php

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserRequest implements RequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $name;

    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email;

    public function __construct(Request $request)
    {
        $this->name = $request->request->get('name');
        $this->email = $request->request->get('email');
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
