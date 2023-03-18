<?php

namespace App\Memories\Domain;

use App\Memories\Domain\Exceptions\InvalidType;
use App\Shared\Domain\Exceptions\CustomException;

class MemoryType
{
    public const LINK = 1;
    public const TEXT = 2;

    /**
     * @throws CustomException
     */
    private function __construct(public readonly int $value)
    {
        if ($value !== self::TEXT && $value !== self::LINK) {
            throw new InvalidType();
        }
    }

    public static function link(): self
    {
        return new self(self::LINK);
    }

    public static function text(): self
    {
        return new self(self::TEXT);
    }

    /**
     * @throws CustomException
     */
    public static function fromValue(int $value): self
    {
        return new self($value);
    }
}