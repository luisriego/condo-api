<?php

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateMovementRequest implements RequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 36, max: 36)]
    private ?string $category;

    #[Assert\NotBlank]
    #[Assert\Length(min: 36, max: 36)]
    private ?string $account;

    #[Assert\NotBlank]
    #[Assert\Length(min: 36, max: 36)]
    private ?string $condo;

    #[Assert\NotBlank]
    private ?int $amount;

    public function __construct(Request $request)
    {
        $this->category = $request->request->get('category');
        $this->account = $request->request->get('account');
        $this->condo = $request->request->get('condo');
        $this->amount = $request->request->get('amount');
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function getCondo(): ?string
    {
        return $this->condo;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }
}
