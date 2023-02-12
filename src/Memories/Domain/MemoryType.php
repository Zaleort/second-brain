<?php

namespace App\Memories\Domain;

use App\Shared\Domain\Exceptions\CustomException;

class MemoryType
{
    /**
     * @throws CustomException
     */
    private function __construct(public readonly int $value)
    {
        if ($value !== 1 && $value !== 2) {
            throw new CustomException('Tipo inválido');
        }
    }

    public static function link(): self
    {
        return new self(1);
    }

    public static function text(): self
    {
        return new self(2);
    }

    public static function fromValue(int $value): self
    {
        return new self($value);
    }
}