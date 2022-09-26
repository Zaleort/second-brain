<?php

namespace App\Categories\Application\CreateCategory;

use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryName;
use App\Categories\Domain\CategoryRepositoryInterface;
use App\Categories\Domain\CustomException;
use App\Categories\Domain\ForbiddenNameException;
use App\Shared\Domain\EventBusInterface;
use App\Shared\Domain\UuidValueObject;

class CreateCategoryHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    /**
     * @throws CategoryAlreadyExistsException
     * @throws ForbiddenNameException
     * @throws CustomException
     */
    public function execute(CreateCategoryCommand $command): void
    {
        $categoryExistent = $this->categoryRepository->findByName($command->name);
        if ($categoryExistent) {
            throw new CategoryAlreadyExistsException('La categoría ya existe');
        }

        $category = Category::create(UuidValueObject::fromValue($command->id), CategoryName::fromValue($command->name));
        $this->categoryRepository->save($category);

        $this->eventBus->dispatchAll($category->getEvents());
    }
}