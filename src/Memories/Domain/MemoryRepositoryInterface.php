<?php

namespace App\Memories\Domain;

use App\Shared\Domain\UuidValueObject;

interface MemoryRepositoryInterface
{
    public function findById(UuidValueObject $id): ?Memory;
    public function findByCriteria(array $criterias): array;

    /**
     * @return Memory[]
     */
    public function findAll(): array;
    public function save(Memory $memory): void;
    public function delete(UuidValueObject $id): void;
    public function count(): int;
}