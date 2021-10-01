<?php

declare(strict_types=1);

namespace App\Trait;

trait TimestampableTrait
{
    use CreatedOnTrait;
    use UpdatedOnTrait;
}
