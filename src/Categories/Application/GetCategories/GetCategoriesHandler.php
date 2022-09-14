<?php

namespace App\Categories\Application\GetCategories;

use App\Categories\Domain\CategoryRepositoryInterface;

class GetCategoriesHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function execute(): array
    {
        return $this->categoryRepository->findAll();
    }
}