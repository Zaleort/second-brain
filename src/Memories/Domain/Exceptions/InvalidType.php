<?php

namespace App\Memories\Domain\Exceptions;

use App\Shared\Domain\Exceptions\CustomException;

class InvalidType extends CustomException
{
    public function __construct(string $message = "Tipo inválido", int $httpCode = 500)
    {
        parent::__construct($message, $httpCode);
    }
}