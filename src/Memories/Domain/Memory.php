<?php

namespace App\Memories\Domain;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\Entity;
use App\Shared\Domain\UuidValueObject;
use DateTimeImmutable;

class Memory extends Entity
{
    function __construct(
        private readonly UuidValueObject $id,
        private readonly MemoryName $name,
        private readonly MemoryType $type,
        private readonly DateTimeImmutable $createdAt,
        private readonly MemoryCategories $categories,
        private ?MemoryContent $content,
        private ?DateTimeImmutable $modifiedAt,
    ) {}

    public static function create(
        UuidValueObject $id,
        MemoryName $name,
        MemoryType $type,
        DateTimeImmutable $createdAt,
        MemoryCategories $categories,
        ?MemoryContent $content,
    ): self
    {
        $memory = new self($id, $name, $type, $createdAt, $categories, $content, null);
        $memory->dispatchCreated();

        return $memory;
    }

    private function dispatchCreated(): void
    {
        $this->events[] = new MemoryCreated($this->id->value);
    }

    public function updateContent(MemoryContent $content): void
    {
        if ($content->value === 'Exception') {
            throw new CustomException('Error');
        }

        $this->content = $content;
        $this->modifiedAt = new DateTimeImmutable();
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