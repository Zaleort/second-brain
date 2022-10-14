<?php

namespace App\Memories\Application\CreateMemory;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\ForbiddenWords\ForbiddenWordChecker;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryContent;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use App\Memories\Domain\SameTypeAndNameChecker;
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
        private readonly SameTypeAndNameChecker $sameTypeAndNameChecker,
        private readonly ForbiddenWordChecker $forbiddenWordChecker,
    ) {
    }

    /**
     * @throws SameTypeAndNameException
     * @throws CustomException
     */
    public function execute(CreateMemoryCommand $command): void
    {
        $this->sameTypeAndNameChecker->assert($command->name, $command->type);

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
            UuidValueObject::fromValue($command->loggedUserId),
            $command->content ? MemoryContent::fromValue($command->content) : null,
            $this->forbiddenWordChecker,
        );

        $this->memoryRepository->save($memory);
        $this->eventBus->dispatchAll($memory->getEvents());
    }
}