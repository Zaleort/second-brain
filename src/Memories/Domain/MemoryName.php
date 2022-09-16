<?php

namespace App\Memories\Domain;

use App\Shared\Domain\StringValueObject;

class MemoryName extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
        if ($this->length() > 100) {
            throw new \Exception('Máximo 100 caracteres');
        }
    }
}