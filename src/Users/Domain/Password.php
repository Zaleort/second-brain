<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\StringValueObject;

class Password extends StringValueObject
{
    public static function encode(string $password): Password
    {
        return new self(password_hash($password, PASSWORD_BCRYPT));
    }

    public function compare(string $password): bool
    {
        return password_verify($password, $this->value);
    }
}