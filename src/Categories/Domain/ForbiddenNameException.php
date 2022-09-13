<?php

namespace App\Categories\Domain;

class ForbiddenNameException extends CustomException
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 400);
    }
}