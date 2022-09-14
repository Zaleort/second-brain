<?php

namespace App\Memories\Infrastructure;

use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MemoryRepository implements MemoryRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function findById(int $id): Memory
    {
        // TODO: Implement findById() method.
        return new Memory('', 0, new \DateTimeImmutable(), [], null, '', null);
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
        return [];
    }

    public function save(Memory $memory)
    {
        // TODO: Implement save() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
