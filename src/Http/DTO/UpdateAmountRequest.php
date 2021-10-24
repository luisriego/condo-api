<?php

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAmountRequest implements RequestDTO
{
    #[Assert\NotBlank]
    private ?int $amount;

    public function __construct(Request $request)
    {
        $this->amount = $request->request->get('amount');
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
