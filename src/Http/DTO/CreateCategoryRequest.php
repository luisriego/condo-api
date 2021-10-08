<?php

namespace App\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCategoryRequest implements RequestDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, max = 50)
     */
    private ?string $name;

    /**
     * @Assert\Choice({"income", "expense"})
     */
    private ?string $type;

    /**
     * @Assert\Length(min = 36, max = 36)
     */
    private ?string $condoId;

    public function __construct(Request $request)
    {
        $this->name = $request->request->get('name');
        $this->type = $request->request->get('type');
        $this->condoId = $request->request->get('condoId');
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCondoId()
    {
        return $this->condoId;
    }
}
