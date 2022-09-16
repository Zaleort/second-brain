<?php

namespace App\Memories\Application\GetMemories;

use App\Memories\Domain\MemoryRepositoryInterface;

class GetMemoriesHandler
{
    public function __construct(private readonly MemoryRepositoryInterface $memoryRepository)
    {
    }

    public function execute(): array
    {
        return $this->memoryRepository->findAll();
    }
}