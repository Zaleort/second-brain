<?php

namespace App\Memories\Application\UpdateMemoryContent;

use App\Memories\Domain\ForbiddenWords\ForbiddenWordChecker;
use App\Memories\Domain\MemoryContent;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\EventBusInterface;
use App\Shared\Domain\Exceptions\CustomException;
use App\Shared\Domain\Uuid;

class UpdateMemoryContentHandler
{
    public function __construct(
        private readonly MemoryRepositoryInterface $memoryRepository,
        private readonly EventBusInterface         $eventBus,
        private readonly ForbiddenWordChecker      $forbiddenWordChecker,
    )
    {
    }

    /**
     * @throws CustomException
     */
    public function execute(UpdateMemoryContentCommand $command): void
    {
        $memory = $this->memoryRepository->findById(Uuid::fromValue($command->id));
        if (!$memory) {
            throw new CustomException('No se ha encontrado la memoria', 404);
        }

        $memory->updateContent(MemoryContent::fromValue($command->content), $this->forbiddenWordChecker);
        $this->memoryRepository->save($memory);

        $this->eventBus->dispatchAll($memory->getEvents());
    }
}