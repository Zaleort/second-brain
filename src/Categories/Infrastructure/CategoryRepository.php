<?php

namespace App\Categories\Infrastructure;

use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryRepositoryInterface;
use App\Categories\Domain\ForbiddenNameException;
use App\Shared\Domain\Exceptions\CustomException;
use Doctrine\ORM\EntityManagerInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Category $category): void
    {
        $repository = $this->entityManager->getRepository(DoctrineCategory::class);
        $doctrineCategory = $repository->find($category->getId()->value) ?? new DoctrineCategory();

        $doctrineCategory->id = $category->getId()->value;
        $doctrineCategory->name = $category->getName()->value;
        $doctrineCategory->userId = $category->getUserId()->value;
        $this->entityManager->persist($doctrineCategory);
        $this->entityManager->flush();
    }

    /**
     * @throws CustomException
     * @throws ForbiddenNameException
     */
    public function findAll(): array
    {
        $repository = $this->entityManager->getRepository(DoctrineCategory::class);
        $doctrineCategories = $repository->findAll();

        $categories = [];
        foreach ($doctrineCategories as $doctrineCategory) {
            $categories[] = Category::fromPrimitives(
                $doctrineCategory->id,
                $doctrineCategory->name,
                $doctrineCategory->userId,
            );
        }

        return $categories;
    }

    /**
     * @throws CustomException
     * @throws ForbiddenNameException
     */
    public function findByName(string $name): ?Category
    {
        $repository = $this->entityManager->getRepository(DoctrineCategory::class);
        $doctrineCategory = $repository->findOneBy(['name' => $name]);
        if (!$doctrineCategory) {
            return null;
        }

        return Category::fromPrimitives(
            $doctrineCategory->id,
            $doctrineCategory->name,
            $doctrineCategory->userId,
        );
    }
}
