<?php

namespace App\Shared\Domain;

class StringValueObject
{
    protected function __construct(public readonly string $value)
    {
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
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