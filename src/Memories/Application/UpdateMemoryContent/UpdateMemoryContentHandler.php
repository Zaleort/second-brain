<?php

namespace App\Memories\Application\UpdateMemoryContent;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryContent;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\UuidValueObject;

class UpdateMemoryContentHandler
{
    public function __construct(private readonly MemoryRepositoryInterface $memoryRepository)
    {
    }

    public function execute(UpdateMemoryContentCommand $command)
    {
        $memory = $this->memoryRepository->findById(UuidValueObject::fromValue($command->id));
        if (!$memory) {
            throw new CustomException('No se ha encontrado la memoria', 404);
        }

        $memory->updateContent(MemoryContent::fromValue($command->content));
        $this->memoryRepository->save($memory);
    }
}