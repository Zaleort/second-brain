<?php

namespace App\Categories\Domain;

use App\Shared\Domain\Entity;
use App\Shared\Domain\UuidValueObject;

class Category extends Entity
{
    public function __construct(private readonly UuidValueObject $id, private readonly CategoryName $name)
    {
    }

    public static function create(UuidValueObject $id, CategoryName $name): self
    {
        $category = new self($id, $name);
        $category->events[] = $id->value;
        
        return $category;
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