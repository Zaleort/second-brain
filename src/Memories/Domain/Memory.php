<?php

namespace App\Memories\Domain;

use App\Categories\Domain\CustomException;
use DateTimeImmutable;

class Memory {
    function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly MemoryType $type,
        private readonly DateTimeImmutable $createdAt,
        private readonly array $categories,
        private readonly ?string $content,
        private readonly ?DateTimeImmutable $modifiedAt,
    ) {}

    public static function create(
        string $id,
        string $name,
        MemoryType $type,
        array $categories,
        ?string $content,
    ): self
    {
        $createdAt = new DateTimeImmutable();
        return new self($id, $name, $type, $createdAt, $categories, $content, null);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): MemoryType
    {
        return $this->type;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getModifiedAt(): ?DateTimeImmutable
    {
        return $this->modifiedAt;
    }
}