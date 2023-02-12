<?php

namespace App\Categories\Domain;

use App\Shared\Domain\Entity;
use App\Shared\Domain\Exceptions\CustomException;
use App\Shared\Domain\Uuid;

class Category extends Entity
{
    private function __construct(
        private readonly CategoryId   $id,
        private readonly CategoryName $name,
        private readonly Uuid         $userId,
    )
    {
    }

    public static function create(CategoryId $id, CategoryName $name, Uuid $userId): self
    {
        $category = new self($id, $name, $userId);
        $category->events[] = new CategoryCreated($id->value);

        return $category;
    }

    /**
     * @throws ForbiddenNameException
     * @throws CustomException
     */
    public static function fromPrimitives(string $id, string $name, string $userId): self
    {
        return new self(
            CategoryId::fromValue($id),
            CategoryName::fromValue($name),
            Uuid::fromValue($userId),
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): CategoryName
    {
        return $this->name;
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }
}