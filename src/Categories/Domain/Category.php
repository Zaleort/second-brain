<?php

namespace App\Categories\Domain;

use App\Shared\Domain\Entity;
use App\Shared\Domain\UuidValueObject;

class Category extends Entity
{
    private function __construct(
        private readonly UuidValueObject $id,
        private readonly CategoryName $name,
        private readonly UuidValueObject $userId,
    ) {
    }

    public static function create(UuidValueObject $id, CategoryName $name, UuidValueObject $userId): self
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
            UuidValueObject::fromValue($id),
            CategoryName::fromValue($name),
            UuidValueObject::fromValue($userId),
        );
    }

    public function getId(): UuidValueObject
    {
        return $this->id;
    }

    public function getName(): CategoryName
    {
        return $this->name;
    }

    public function getUserId(): UuidValueObject
    {
        return $this->userId;
    }
}