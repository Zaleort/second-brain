<?php

namespace App\Categories\Domain;

use App\Categories\Domain\Category;

interface CategoryRepositoryInterface
{
    public function findByName(string $name): Category | null;
    public function save(Category $category): void;
}