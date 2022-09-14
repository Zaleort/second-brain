<?php

namespace App\Categories\Infrastructure;

use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Category $category): void
    {
        $repository = $this->entityManager->getRepository(DoctrineCategory::class);
        $doctrineCategory = $repository->find($category->getId()) ?? new DoctrineCategory();

        $doctrineCategory->id = $category->getId();
        $doctrineCategory->name = $category->getName();
        $this->entityManager->persist($doctrineCategory);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        $repository = $this->entityManager->getRepository(DoctrineCategory::class);
        $doctrineCategories = $repository->findAll();

        $categories = [];
        foreach ($doctrineCategories as $doctrineCategory) {
            $categories[] = new Category($doctrineCategory->id, $doctrineCategory->name);
        }

        return $categories;
    }

    public function findByName(string $name): ?Category
    {
        $repository = $this->entityManager->getRepository(DoctrineCategory::class);
        $doctrineCategory = $repository->findOneBy(['name' => $name]);
        if (!$doctrineCategory) {
            return null;
        }

        return new Category($doctrineCategory->id, $doctrineCategory->name);
    }
}
