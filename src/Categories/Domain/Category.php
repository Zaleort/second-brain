<?php

namespace App\Categories\Domain;

use App\Shared\Domain\UuidValueObject;

class Category
{
    public function __construct(private readonly UuidValueObject $id, private readonly CategoryName $name)
    {
    }

    public static function create(UuidValueObject $id, CategoryName $name): self
    {
        return new self($id, $name);
    }

    public function getId(): UuidValueObject
    {
        return $this->id;
    }

    public function getName(): CategoryName
    {
        return $this->name;
    }
}