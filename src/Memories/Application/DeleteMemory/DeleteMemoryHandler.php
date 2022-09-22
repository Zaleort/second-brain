<?php

namespace App\Memories\Application\DeleteMemory;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\UuidValueObject;

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
        $this->memoryRepository->delete(UuidValueObject::fromValue($command->id));
    }
}