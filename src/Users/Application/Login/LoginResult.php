<?php

declare(strict_types=1);

namespace App\Users\Application\Login;

class LoginResult
{
    public function __construct(public readonly string $id)
    {
    }
}