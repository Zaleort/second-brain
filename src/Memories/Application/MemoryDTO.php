<?php

namespace App\Memories\Application;

use App\Memories\Domain\Memory;

class MemoryDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $type,
        public readonly array $categories,
        public readonly \DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $modifiedAt,
        public readonly ?string $content,
    ) {}

    public static function fromEntity(Memory $memory): self
    {
        $categories = [];
        foreach ($memory->getCategories()->getValues() as $id) {
            $categories[] = $id->value;
        }

        return new MemoryDTO(
            $memory->getId()->value,
            $memory->getName()->value,
            $memory->getType()->value,
            $categories,
            $memory->getCreatedAt(),
            $memory->getModifiedAt(),
            $memory->getContent()->value,
        );
    }
}