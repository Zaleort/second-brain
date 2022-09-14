<?php

namespace App\Memories\Domain;

use DateTimeImmutable;

class Memory {
    public function __construct(
        private readonly string $name,
        private readonly int $type,
        private readonly DateTimeImmutable $createdAt,
        private readonly array $categories,
        private readonly ?int $id,
        private readonly ?string $content,
        private readonly ?DateTimeImmutable $modifiedAt,
    ) {}

    public function create(
        string $name,
        int $type,
        array $categories,
        ?string $content,
    ): self
    {
        $createdAt = new DateTimeImmutable();
        return new self($name, $type, $createdAt, $categories, null, $content, null);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getModifiedAt(): ?DateTimeImmutable
    {
        return $this->modifiedAt;
    }
}