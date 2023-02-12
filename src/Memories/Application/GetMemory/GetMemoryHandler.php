<?php

namespace App\Memories\Application\GetMemory;

use App\Memories\Application\MemoryDTO;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\Exceptions\CustomException;
use Ramsey\Uuid\Uuid;

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
        $memory = $this->memoryRepository->findById(Uuid::fromValue($command->id));
        if (!$memory) {
            throw new CustomException('No se ha encontrado ninguna memoria con id ' . $command->id, 404);
        }

        return MemoryDTO::fromEntity($memory);
    }
}