<?php

namespace App\Memories\Application\CreateMemory;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryContent;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use App\Memories\Domain\SameTypeAndNameException;
use App\Shared\Domain\Clock;
use App\Shared\Domain\EventBusInterface;
use App\Shared\Domain\UuidValueObject;

class CreateMemoryHandler
{
    public function __construct(
        private readonly MemoryRepositoryInterface $memoryRepository,
        private readonly Clock $clock,
        private readonly EventBusInterface $eventBus,
    ) {}

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

        $categories = new MemoryCategories();
        foreach ($command->categories as $category) {
            $categories->add(UuidValueObject::fromValue($category));
        }

        $memory = Memory::create(
            UuidValueObject::fromvalue($command->id),
            MemoryName::fromValue($command->name),
            MemoryType::fromValue($command->type),
            $this->clock->now(),
            $categories,
            $command->content ? MemoryContent::fromValue($command->content) : null,
        );

        $this->memoryRepository->save($memory);
        $this->eventBus->dispatchAll($memory->getEvents());
    }
}