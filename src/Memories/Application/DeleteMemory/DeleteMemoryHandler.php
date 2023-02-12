<?php

namespace App\Memories\Application\DeleteMemory;

use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\Exceptions\CustomException;
use App\Shared\Domain\Uuid;

class DeleteMemoryHandler
{
    public function __construct(private readonly MemoryRepositoryInterface $memoryRepository)
    {
    }

    /**
     * @throws CustomException
     */
    public function execute(DeleteMemoryCommand $command): void
    {
        $this->memoryRepository->delete(Uuid::fromValue($command->id));
    }
}