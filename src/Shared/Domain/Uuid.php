<?php

namespace App\Shared\Domain;

use App\Shared\Domain\Exceptions\CustomException;

class Uuid
{
    /**
     * @throws CustomException
     */
    protected function __construct(public readonly string $value)
    {
        if (strlen($value) !== 36) {
            throw new CustomException('El uuid no es válido');
        }
    }

    /**
     * @throws CustomException
     */
    public static function fromValue(string $id): static
    {
        return new static($id);
    }
}