<?php

namespace App\Categories\Application;

use App\Categories\Domain\Category;

class CategoryDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}

    public static function fromEntity(Category $category): self
    {
        return new self(
            $category->getId()->value,
            $category->getName()->value,
        );
    }
}