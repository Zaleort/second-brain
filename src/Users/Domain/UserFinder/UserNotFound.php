<?php

namespace App\Users\Domain\UserFinder;

use App\Shared\Domain\Exceptions\CustomException;

class UserNotFound extends CustomException
{
    public function __construct(string $message = "User not found", int $httpCode = 404)
    {
        parent::__construct($message, $httpCode);
    }
}