<?php

declare(strict_types=1);

namespace App\Memories\Domain\ForbiddenWords;

use App\Shared\Domain\Exceptions\CustomException;

class ForbiddenWordException extends CustomException
{
    public function __construct(string $message = "No puedes usar palabras prohibidas", int $httpCode = 400)
    {
        parent::__construct($message, $httpCode);
    }
}