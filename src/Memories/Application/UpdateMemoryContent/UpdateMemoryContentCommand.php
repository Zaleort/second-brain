<?php

namespace App\Memories\Application\UpdateMemoryContent;

class UpdateMemoryContentCommand
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $content
    ) {}
}