<?php

namespace App\Memories\Domain;

use App\Shared\Domain\Uuid;

interface MemoryRepositoryInterface
{
    public function findById(Uuid $id): ?Memory;
    public function findByCriteria(array $criterias): array;

    /**
     * @return Memory[]
     */
    public function findAll(): array;
    public function save(Memory $memory): void;
    public function delete(Uuid $id): void;
    public function count(): int;
}