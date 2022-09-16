<?php

namespace App\Memories\Infrastructure;

use App\Categories\Infrastructure\DoctrineCategory;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MemoryRepository implements MemoryRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function findById(int $id): Memory
    {
        // TODO: Implement findById() method.
        return new Memory('', 0, MemoryType::link(), new \DateTimeImmutable(), [], null, null);
    }

    public function findAll(): array
    {
        $doctrineMemories = $this->entityManager->getRepository(DoctrineMemory::class)->findAll();
        return $this->getMemoriesFromDoctrine($doctrineMemories);
    }

    public function findByCriteria(array $criterias): array
    {
        $doctrineMemories = $this->entityManager->getRepository(DoctrineMemory::class)->findBy($criterias);
        return $this->getMemoriesFromDoctrine($doctrineMemories);
    }

    public function save(Memory $memory): void
    {
        $doctrineMemory = $this->entityManager->find(DoctrineMemory::class, $memory->getId()) ?? new DoctrineMemory();
        $doctrineMemory->id = $memory->getId();
        $doctrineMemory->name = $memory->getName();
        $doctrineMemory->type = $memory->getType()->value;
        $doctrineMemory->content = $memory->getContent();
        $doctrineMemory->createdAt = $memory->getCreatedAt();
        $doctrineMemory->modifiedAt = $memory->getModifiedAt();

        $doctrineMemory->categories->clear();
        foreach ($memory->getCategories() as $categoryId) {
            $category = $this->entityManager->find(DoctrineCategory::class, $categoryId);
            $doctrineMemory->categories->add($category);
        }

        $this->entityManager->persist($doctrineMemory);
        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param array $doctrineMemories
     * @return array
     */
    public function getMemoriesFromDoctrine(array $doctrineMemories): array
    {
        $memories = [];
        foreach ($doctrineMemories as $doctrineMemory) {
            $categories = [];
            foreach ($doctrineMemory->categories as $category) {
                $categories[] = $category->id;
            }

            $memories[] = new Memory(
                $doctrineMemory->id,
                $doctrineMemory->name,
                MemoryType::fromValue($doctrineMemory->type),
                $doctrineMemory->createdAt,
                $categories,
                $doctrineMemory->content,
                $doctrineMemory->modifiedAt,
            );
        }

        return $memories;
    }
}
