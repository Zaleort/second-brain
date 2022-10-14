<?php

namespace App\Tests\unit\Memories\Application\CreateMemory;

use App\Categories\Domain\CustomException;
use App\Memories\Application\CreateMemory\CreateMemoryCommand;
use App\Memories\Application\CreateMemory\CreateMemoryHandler;
use App\Memories\Domain\ForbiddenWords\ForbiddenWordChecker;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCreated;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\SameTypeAndNameChecker;
use App\Memories\Domain\SameTypeAndNameException;
use App\Shared\Domain\Clock;
use App\Shared\Domain\EventBusInterface;
use PHPUnit\Framework\TestCase;

class CreateMemoryHandlerTest extends TestCase
{
    private string $memoryId;
    private string $userId;
    private string $memoryName;
    private \DateTimeImmutable $memoryCreatedAt;

    protected function setUp(): void
    {
        parent::setUp();
        $this->memoryId = '0379688f-2983-4a16-b2de-ad3976d540da';
        $this->userId = '0379688f-2983-4a16-b2de-ad3976d540da';
        $this->memoryName = 'Name';
        $this->memoryCreatedAt = new \DateTimeImmutable();
    }

    public function test_create_memory(): void
    {
        $this->markTestSkipped('Pospuesto corrección del test');
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->expects($spy = self::any())->method('save')->with($this->getExpectedMemory());
        $forbiddenWords = $this->createMock(ForbiddenWordChecker::class);
        $sameTypeAndName = $this->createMock(SameTypeAndNameChecker::class);
        $eventBus = $this->createMock(EventBusInterface::class);

        $clock = $this->createMock(Clock::class);
        $clock->method('now')->willReturn($this->memoryCreatedAt);

        $handler = new CreateMemoryHandler($repository, $clock, $eventBus, $sameTypeAndName, $forbiddenWords);

        $command = new CreateMemoryCommand($this->memoryId, $this->memoryName, 1, [], $this->userId, null);
        $handler->execute($command);

        $this->assertTrue($spy->hasBeenInvoked());
    }

    /**
     * @throws CustomException
     * @throws SameTypeAndNameException
     */
    public function test_dispatch_memory_created_event(): void
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $eventBus = $this->createMock(EventBusInterface::class);
        $eventBus->expects($eventSpy = self::any())->method('dispatchAll')->with([new MemoryCreated($this->memoryId)]);
        $forbiddenWords = $this->createMock(ForbiddenWordChecker::class);
        $sameTypeAndName = $this->createMock(SameTypeAndNameChecker::class);

        $clock = $this->createMock(Clock::class);
        $clock->method('now')->willReturn($this->memoryCreatedAt);

        $handler = new CreateMemoryHandler($repository, $clock, $eventBus, $sameTypeAndName, $forbiddenWords);

        $command = new CreateMemoryCommand($this->memoryId, $this->memoryName, 1, [], $this->userId, null);
        $handler->execute($command);

        $this->assertTrue($eventSpy->hasBeenInvoked());
    }

    /**
     * @throws CustomException
     */
    private function getExpectedMemory(): Memory
    {
        return Memory::fromPrimitives(
            $this->memoryId,
            $this->memoryName,
            1,
            $this->memoryCreatedAt,
            [],
            $this->userId,
            null,
        );
    }
}