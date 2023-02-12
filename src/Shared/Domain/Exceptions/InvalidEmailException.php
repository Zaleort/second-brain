<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

class InvalidEmailException extends CustomException
{

    public function __construct()
    {
        parent::__construct('Invalid email', 400);
    }
}