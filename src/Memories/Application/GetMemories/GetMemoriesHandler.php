<?php

namespace App\Memories\Application\GetMemories;

use App\Memories\Application\MemoryDTO;
use App\Memories\Domain\MemoryRepositoryInterface;

class GetMemoriesHandler
{
    public function __construct(private readonly MemoryRepositoryInterface $memoryRepository)
    {
    }

    public function execute(): array
    {
        $memories = $this->memoryRepository->findAll();
        $memoriesDTO = [];

        foreach ($memories as $memory) {
            $memoriesDTO[] = MemoryDTO::fromEntity($memory);
        }

        return $memoriesDTO;
    }
}