<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Exceptions\InvalidEmailException;

class EmailAddress
{
    /**
     * @throws InvalidEmailException
     */
    protected function __construct(public readonly string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }
    }

    /**
     * @throws InvalidEmailException
     */
    public static function fromValue(string $email): static
    {
        return new static($email);
    }
}