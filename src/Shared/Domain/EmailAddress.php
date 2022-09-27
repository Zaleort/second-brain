<?php

declare(strict_types=1);

namespace App\Shared\Domain;

class EmailAddress
{
    /**
     * @throws InvalidEmailException
     */
    private function __construct(public readonly string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }
    }

    /**
     * @throws InvalidEmailException
     */
    public static function fromValue(string $email): self
    {
        return new self($email);
    }
}