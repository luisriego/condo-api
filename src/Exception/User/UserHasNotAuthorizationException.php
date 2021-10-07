<?php

declare(strict_types=1);

namespace App\Exception\User;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserHasNotAuthorizationException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You has not authorization for this task');
    }
}