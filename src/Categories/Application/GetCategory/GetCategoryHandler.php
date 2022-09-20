<?php

namespace App\Categories\Application\GetCategory;

use App\Categories\Application\CategoryDTO;
use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryRepositoryInterface;

class GetCategoryHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function execute(GetCategoryCommand $command): ?CategoryDTO
    {
        $category = $this->categoryRepository->findByName($command->name);
        if (!$category) {
            return null;
        }

        return CategoryDTO::fromEntity($category);
    }
}