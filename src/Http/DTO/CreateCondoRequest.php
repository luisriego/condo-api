<?php

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCondoRequest implements RequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 60)]
    private ?string $fantasyName;

    #[Assert\NotBlank]
    #[Assert\Length(min: 14, max: 14)]
    private ?string $cnpj;

    public function __construct(Request $request)
    {
        $this->fantasyName = $request->request->get('fantasyName');
        $this->cnpj = $request->request->get('cnpj');
    }

    public function getFantasyName(): ?string
    {
        return $this->fantasyName;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }
}
