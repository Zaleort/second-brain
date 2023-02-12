<?php

namespace App\Memories\Domain;

use App\Shared\Domain\Exceptions\CustomException;
use App\Shared\Domain\StringValueObject;

class MemoryName extends StringValueObject
{
    /**
     * @throws CustomException
     */
    private function __construct(string $value)
    {
        parent::__construct($value);
        if ($this->length() > 100) {
            throw new CustomException('Máximo 100 caracteres');
        }
    }

    /**
     * @throws CustomException
     */
    public static function fromValue(string $value): self
    {
        return new self($value);
    }
}