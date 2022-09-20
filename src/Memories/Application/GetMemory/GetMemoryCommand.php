<?php

namespace App\Memories\Application\GetMemory;

class GetMemoryCommand
{
    public function __construct(public readonly string $id)
    {
    }
}