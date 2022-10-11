<?php

namespace App\Memories\Infrastructure;

use App\Categories\Domain\CustomException;
use App\Categories\Infrastructure\DoctrineCategory;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\UuidValueObject;
use Doctrine\ORM\EntityManagerInterface;

class MemoryRepository implements MemoryRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws CustomException
     */
    public function findById(UuidValueObject $id): ?Memory
    {
        $doctrineMemory = $this->entityManager->getRepository(DoctrineMemory::class)->find($id->value);
        if (!$doctrineMemory) {
            return null;
        }

        $categories = [];
        foreach ($doctrineMemory->categories as $category) {
            $categories[] = $category->id;
        }

        return Memory::fromPrimitives(
            $doctrineMemory->id,
            $doctrineMemory->name,
            $doctrineMemory->type,
            $doctrineMemory->createdAt,
            $categories,
            $doctrineMemory->userId,
            $doctrineMemory->content,
            $doctrineMemory->modifiedAt,
        );
    }

    /**
     * @throws CustomException
     */
    public function findAll(): array
    {
        $doctrineMemories = $this->entityManager->getRepository(DoctrineMemory::class)->findAll();
        return $this->getMemoriesFromDoctrine($doctrineMemories);
    }

    /**
     * @throws CustomException
     */
    public function findByCriteria(array $criterias): array
    {
        $doctrineMemories = $this->entityManager->getRepository(DoctrineMemory::class)->findBy($criterias);
        return $this->getMemoriesFromDoctrine($doctrineMemories);
    }

    public function save(Memory $memory): void
    {
        $doctrineMemory = $this->entityManager->find(
            DoctrineMemory::class,
            $memory->getId()->value
        ) ?? new DoctrineMemory();
        $doctrineMemory->id = $memory->getId()->value;
        $doctrineMemory->name = $memory->getName()->value;
        $doctrineMemory->type = $memory->getType()->value;
        $doctrineMemory->userId = $memory->getUserId()->value;
        $doctrineMemory->content = $memory->getContent()->value;
        $doctrineMemory->createdAt = $memory->getCreatedAt();
        $doctrineMemory->modifiedAt = $memory->getModifiedAt();

        $doctrineMemory->categories->clear();
        foreach ($memory->getCategories()->getValues() as $categoryId) {
            $category = $this->entityManager->find(DoctrineCategory::class, $categoryId->value);
            $doctrineMemory->categories->add($category);
        }

        $this->entityManager->persist($doctrineMemory);
        $this->entityManager->flush();
    }

    /**
     * @throws CustomException
     */
    public function delete(UuidValueObject $id): void
    {
        $memory = $this->entityManager->find(DoctrineMemory::class, $id->value);
        if (!$memory) {
            throw new CustomException('No existe la memoria', 404);
        }

        $this->entityManager->remove($memory);
        $this->entityManager->flush();
    }

    /**
     * @param array $doctrineMemories
     * @return array
     * @throws CustomException
     */
    public function getMemoriesFromDoctrine(array $doctrineMemories): array
    {
        $memories = [];
        foreach ($doctrineMemories as $doctrineMemory) {
            $categories = [];
            foreach ($doctrineMemory->categories as $category) {
                $categories[] = $category->id;
            }

            $memories[] = Memory::fromPrimitives(
                $doctrineMemory->id,
                $doctrineMemory->name,
                $doctrineMemory->type,
                $doctrineMemory->createdAt,
                $categories,
                $doctrineMemory->userId,
                $doctrineMemory->content,
                $doctrineMemory->modifiedAt,
            );
        }

        return $memories;
    }

    public function count(): int
    {
        return $this->entityManager->getRepository(DoctrineMemory::class)->count([]);
    }
}
