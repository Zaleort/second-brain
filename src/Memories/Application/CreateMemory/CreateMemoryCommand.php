<?php

namespace App\Memories\Application\CreateMemory;

class CreateMemoryCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $type,
        public readonly array $categories,
        public readonly string $loggedUserId,
        public readonly ?string $content = null,
    ) {
    }
}