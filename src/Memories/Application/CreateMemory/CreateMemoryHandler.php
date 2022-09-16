<?php

namespace App\Memories\Application\CreateMemory;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use App\Memories\Domain\SameTypeAndNameException;

class CreateMemoryHandler
{
    public function __construct(private readonly MemoryRepositoryInterface $memoryRepository)
    {
    }

    /**
     * @throws SameTypeAndNameException
     * @throws CustomException
     */
    public function execute(CreateMemoryCommand $command): void
    {
        $memories = $this->memoryRepository->findByCriteria(['name' => $command->name, 'type' => $command->type]);
        if (count($memories) > 0) {
            throw new SameTypeAndNameException('No puede haber una memoria con el mismo nombre y tipo');
        }

        $memory = Memory::create(
            $command->id,
            $command->name,
            MemoryType::fromValue($command->type),
            $command->categories,
            $command->content
        );

        $this->memoryRepository->save($memory);
    }
}