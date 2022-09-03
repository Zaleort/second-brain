<?php

namespace App\Categories\Application\CreateCategory;

use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryRepositoryInterface;
use App\Categories\Domain\TestService;

class CreateCategoryHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function execute(CreateCategoryCommand $command): void
    {
        $category = Category::create($command->name);
        $this->categoryRepository->save($category);
    }
}