<?php

namespace App\Tests\unit\Memories\Application\UpdateMemoryContent;

use App\Memories\Application\UpdateMemoryContent\UpdateMemoryContentCommand;
use App\Memories\Application\UpdateMemoryContent\UpdateMemoryContentHandler;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryContent;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use App\Shared\Domain\UuidValueObject;
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

        $handler = new UpdateMemoryContentHandler($repository);
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
        return Memory::create(
            UuidValueObject::fromValue($this->memoryId),
            MemoryName::fromValue('Name'),
            MemoryType::fromValue(1),
            new \DateTimeImmutable('2022-01-01'),
            new MemoryCategories(),
            null,
        );
    }
}