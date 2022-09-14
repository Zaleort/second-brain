<?php

namespace App\Memories\Domain;

interface MemoryRepositoryInterface
{
    public function findById(int $id): Memory;
    public function findAll(): array;
    public function save(Memory $memory);
    public function delete(int $id);
}