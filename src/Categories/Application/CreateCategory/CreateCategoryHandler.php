<?php

namespace App\Categories\Application\CreateCategory;

use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryRepositoryInterface;
use App\Categories\Domain\ForbiddenNameException;
use App\Categories\Domain\TestService;

class CreateCategoryHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {
    }

    /**
     * @throws CategoryAlreadyExistsException
     * @throws ForbiddenNameException
     */
    public function execute(CreateCategoryCommand $command): void
    {
        $categoryExistent = $this->categoryRepository->findByName($command->name);
        if ($categoryExistent) {
            throw new CategoryAlreadyExistsException('La categoría ya existe');
        }

        $category = Category::create($command->id, $command->name);
        $this->categoryRepository->save($category);
    }
}