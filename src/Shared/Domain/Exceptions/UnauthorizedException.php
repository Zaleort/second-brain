<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

class UnauthorizedException extends CustomException
{
    private int $httpCode;

    public function __construct(string $message = 'Unauthorized')
    {
        parent::__construct($message, 401);
    }
}
