<?php

namespace App\Memories\Domain;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\UuidValueObject;
use DateTimeImmutable;

class Memory {
    function __construct(
        private readonly UuidValueObject $id,
        private readonly MemoryName $name,
        private readonly MemoryType $type,
        private readonly DateTimeImmutable $createdAt,
        private readonly MemoryCategories $categories,
        private readonly ?MemoryContent $content,
        private readonly ?DateTimeImmutable $modifiedAt,
    ) {}

    public static function create(
        UuidValueObject $id,
        MemoryName $name,
        MemoryType $type,
        MemoryCategories $categories,
        ?MemoryContent $content,
    ): self
    {
        $createdAt = new DateTimeImmutable();
        return new self($id, $name, $type, $createdAt, $categories, $content, null);
    }

    public function getId(): UuidValueObject
    {
        return $this->id;
    }

    public function getName(): MemoryName
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

    public function getCategories(): MemoryCategories
    {
        return $this->categories;
    }

    public function getContent(): ?MemoryContent
    {
        return $this->content;
    }

    public function getModifiedAt(): ?DateTimeImmutable
    {
        return $this->modifiedAt;
    }
}