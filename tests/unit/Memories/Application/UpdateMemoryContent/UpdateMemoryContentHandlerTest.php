<?php

namespace App\Tests\unit\Memories\Application\UpdateMemoryContent;

use App\Memories\Application\UpdateMemoryContent\UpdateMemoryContentCommand;
use App\Memories\Application\UpdateMemoryContent\UpdateMemoryContentHandler;
use App\Memories\Domain\ContentUpdated;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryContent;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use App\Shared\Domain\EventBusInterface;
use App\Shared\Domain\UuidValueObject;
use App\Tests\Mothers\MemoryMother;
use PHPUnit\Framework\TestCase;

class UpdateMemoryContentHandlerTest extends TestCase
{
    private string $memoryId;
    private string $memoryContent;

    protected function setUp(): void
    {
        parent::setUp();
        $this->memoryId = '0379688f-2983-4a16-b2de-ad3976d540da';
        $this->memoryContent = 'Test';
    }

    public function test_update_memory_content_given_id()
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->method('findById')->willReturn($this->getMemory());
        $repository->expects($spy = self::any())->method('save')->with(
            self::callback(
                fn (Memory $memory) => $memory->getContent()->value === $this->getExpectedMemory()->getContent()->value
            )
        );

        $eventBus = $this->createMock(EventBusInterface::class);

        $handler = new UpdateMemoryContentHandler($repository, $eventBus);
        $command = new UpdateMemoryContentCommand($this->memoryId, $this->memoryContent);
        $handler->execute($command);

        $this->assertTrue($spy->hasBeenInvoked());
    }

    public function test_dipatch_content_updated_event()
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->method('findById')->willReturn($this->getMemory());

        $eventBus = $this->createMock(EventBusInterface::class);
        $eventBus->expects($spy = self::any())->method('dispatchAll')->with([new ContentUpdated($this->memoryId)]);

        $handler = new UpdateMemoryContentHandler($repository, $eventBus);
        $command = new UpdateMemoryContentCommand($this->memoryId, $this->memoryContent);
        $handler->execute($command);

        $this->assertTrue($spy->hasBeenInvoked());
    }

    private function getExpectedMemory(): Memory {
        $memory = $this->getMemory();
        $memory->updateContent(MemoryContent::fromValue($this->memoryContent));

        return $memory;
    }

    private function getMemory(): Memory
    {
        return MemoryMother::withId($this->memoryId);
    }
}