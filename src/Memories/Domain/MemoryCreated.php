<?php

namespace App\Memories\Domain;

class MemoryCreated
{
    public function __construct(public readonly string $id)
    {
    }
}