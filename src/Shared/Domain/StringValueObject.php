<?php

namespace App\Shared\Domain;

class StringValueObject
{
    public function __construct(public readonly string $value)
    {
    }

    public function length(): int
    {
        return strlen($this->value);
    }

    public function substring(int $start, int $end): string
    {
        return substr($this->value, $start, $end);
    }

}