<?php

namespace App\Categories\Application\GetCategories;

use App\Categories\Application\CategoryDTO;
use App\Categories\Domain\CategoryRepositoryInterface;

class GetCategoriesHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function execute(): array
    {
        $categories = $this->categoryRepository->findAll();
        $categoriesDTO = [];

        foreach ($categories as $category) {
            $categoriesDTO[] = CategoryDTO::fromEntity($category);
        }

        return $categoriesDTO;
    }
}