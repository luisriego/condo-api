<?php

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateFantasyNameRequest implements RequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $fantasyName;

    public function __construct(Request $request)
    {
        $this->fantasyName = $request->request->get('fantasyName');
    }

    public function getFanatasyName(): ?string
    {
        return $this->fantasyName;
    }
}
