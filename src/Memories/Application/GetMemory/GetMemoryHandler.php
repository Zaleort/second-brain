<?php

namespace App\Memories\Application\GetMemory;

use App\Categories\Domain\CustomException;
use App\Memories\Application\MemoryDTO;
use App\Memories\Domain\MemoryRepositoryInterface;

class GetMemoryHandler
{
    public function __construct(private readonly MemoryRepositoryInterface $memoryRepository)
    {
    }

    /**
     * @throws CustomException
     */
    public function execute(GetMemoryCommand $command): MemoryDTO
    {
        $memory = $this->memoryRepository->findById($command->id);
        if (!$memory) {
            throw new CustomException('No se ha encontrado ninguna memoria con id '.$command->id, 404);
        }

        return MemoryDTO::fromEntity($memory);
    }
}