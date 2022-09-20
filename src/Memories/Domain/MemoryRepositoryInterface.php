<?php

namespace App\Memories\Domain;

interface MemoryRepositoryInterface
{
    public function findById(string $id): ?Memory;
    public function findByCriteria(array $criterias): array;

    /**
     * @return Memory[]
     */
    public function findAll(): array;
    public function save(Memory $memory);
    public function delete(int $id);
}