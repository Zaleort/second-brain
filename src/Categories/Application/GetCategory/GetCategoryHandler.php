<?php

namespace App\Categories\Application\GetCategory;

use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryRepositoryInterface;

class GetCategoryHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function execute(GetCategoryCommand $command): Category | null
    {
        return $this->categoryRepository->findByName($command->name);
    }
}