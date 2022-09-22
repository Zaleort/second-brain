<?php

namespace App\Tests\unit\Memories\Application\CreateMemory;

use App\Memories\Application\CreateMemory\CreateMemoryCommand;
use App\Memories\Application\CreateMemory\CreateMemoryHandler;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use App\Shared\Domain\Clock;
use App\Shared\Domain\UuidValueObject;
use PHPUnit\Framework\TestCase;

class CreateMemoryHandlerTest extends TestCase
{
    private string $memoryId;
    private string $memoryName;
    private \DateTimeImmutable $memoryCreatedAt;

    protected function setUp(): void
    {
        parent::setUp();
        $this->memoryId = '0379688f-2983-4a16-b2de-ad3976d540da';
        $this->memoryName = 'Name';
        $this->memoryCreatedAt = new \DateTimeImmutable();
    }

    public function test_create_memory(): void
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->expects($spy = self::any())->method('save')->with($this->getExpectedMemory());

        $clock = $this->createMock(Clock::class);
        $clock->method('now')->willReturn($this->memoryCreatedAt);

        $handler = new CreateMemoryHandler($repository, $clock);

        $command = new CreateMemoryCommand($this->memoryId, $this->memoryName, 1, [], null);
        $handler->execute($command);

        $this->assertTrue($spy->hasBeenInvoked());
    }

    private function getExpectedMemory(): Memory
    {
        return Memory::create(
            UuidValueObject::fromValue($this->memoryId),
            MemoryName::fromValue($this->memoryName),
            MemoryType::fromValue(1),
            $this->memoryCreatedAt,
            new MemoryCategories(),
            null,
        );
    }
}