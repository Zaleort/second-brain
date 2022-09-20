<?php

namespace App\Shared\Domain;

use App\Categories\Domain\CustomException;
use Ramsey\Uuid\Uuid;

class UuidValueObject
{
    /**
     * @throws CustomException
     */
    private function __construct(public readonly string $value)
    {
        if (strlen($value) !== 36) {
            throw new CustomException('El uuid no es válido');
        }
    }

    /**
     * @throws CustomException
     */
    public static function fromValue(string $id): self {
        return new self($id);
    }
}