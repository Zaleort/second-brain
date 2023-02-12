<?php

namespace App\Categories\Domain;

use App\Shared\Domain\Exceptions\CustomException;

class ForbiddenNameException extends CustomException
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 400);
    }
}