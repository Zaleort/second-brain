<?php

namespace App\Memories\Application\DeleteMemory;

class DeleteMemoryCommand
{
    public function __construct(public readonly string $id)
    {
    }
}