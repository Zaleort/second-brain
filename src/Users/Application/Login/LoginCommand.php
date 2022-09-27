<?php

declare(strict_types=1);

namespace App\Users\Application\Login;

class LoginCommand
{
    public function __construct(public readonly string $email, public readonly string $password)
    {
    }
}