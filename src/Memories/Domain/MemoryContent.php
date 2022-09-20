<?php

namespace App\Memories\Domain;

class MemoryContent
{
    private function __construct(public readonly ?string $value)
    {
    }

    public static function fromValue(?string $value): self {
        return new self($value);
    }
}