<?php

namespace App\Memories\Domain;

use App\Categories\Domain\ForbiddenNameException;
use App\Memories\Domain\ForbiddenWords\ForbiddenWordChecker;
use App\Shared\Domain\Entity;
use App\Shared\Domain\Exceptions\CustomException;
use App\Users\Domain\UserId;
use DateTimeImmutable;

class Memory extends Entity
{
    private function __construct(
        private readonly MemoryId          $id,
        private readonly MemoryName        $name,
        private readonly MemoryType        $type,
        private readonly DateTimeImmutable $createdAt,
        private readonly MemoryCategories  $categories,
        private readonly UserId            $userId,
        private ?MemoryContent             $content,
        private ?DateTimeImmutable         $modifiedAt,
    )
    {
    }

    /**
     * @throws ForbiddenNameException
     */
    public static function create(
        MemoryId             $id,
        MemoryName           $name,
        MemoryType           $type,
        DateTimeImmutable    $createdAt,
        MemoryCategories     $categories,
        UserId               $userId,
        MemoryContent|null   $content,
        ForbiddenWordChecker $forbiddenWordChecker,
    ): self
    {
        $forbiddenWordChecker->assert($content?->value);

        $memory = new self($id, $name, $type, $createdAt, $categories, $userId, $content, null);
        $memory->dispatchCreated();

        return $memory;
    }

    /**
     * @throws CustomException
     */
    public static function fromPrimitives(
        string            $id,
        string            $name,
        int               $type,
        DateTimeImmutable $createdAt,
        array             $categories,
        string            $userId,
        ?string           $content
    ): self
    {
        return new self(
            MemoryId::fromValue($id),
            MemoryName::fromValue($name),
            MemoryType::fromValue($type),
            $createdAt,
            MemoryCategories::fromArray($categories),
            UserId::fromValue($userId),
            $content ? MemoryContent::fromValue($content) : null,
            null,
        );
    }

    private function dispatchCreated(): void
    {
        $this->events[] = new MemoryCreated($this->id->value);
    }

    /**
     * @throws CustomException
     */
    public function updateContent(MemoryContent $content, ForbiddenWordChecker $checker): void
    {
        $checker->assert($content->value);

        $this->content = $content;
        $this->modifiedAt = new DateTimeImmutable();

        $this->events[] = new ContentUpdated($this->id->value);
    }

    public function getId(): MemoryId
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

    public function getUserId(): UserId
    {
        return $this->userId;
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