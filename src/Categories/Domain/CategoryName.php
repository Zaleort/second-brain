<?php

namespace App\Categories\Domain;

use App\Shared\Domain\StringValueObject;

class CategoryName extends StringValueObject
{
    /**
     * @throws ForbiddenNameException
     */
    private function __construct(string $value)
    {
        parent::__construct($value);
        if ($value === 'Brokalia') {
            throw new ForbiddenNameException('El nombre no puede contener Brokalia');
        }
    }

    /**
     * @throws ForbiddenNameException
     */
    public static function fromValue(string $value): self
    {
        return new self($value);
    }
}