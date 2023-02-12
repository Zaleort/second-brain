<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\StringValueObject;

class UserPassword extends StringValueObject
{
    public static function encode(string $password): UserPassword
    {
        return new self(password_hash($password, PASSWORD_BCRYPT));
    }

    public function compare(string $password): bool
    {
        return password_verify($password, $this->value);
    }
}