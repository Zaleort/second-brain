<?php

namespace App\Tests\unit\Memories\Application\DeleteMemory;

use App\Memories\Application\DeleteMemory\DeleteMemoryCommand;
use App\Memories\Application\DeleteMemory\DeleteMemoryHandler;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\Uuid;
use PHPUnit\Framework\TestCase;

class DeleteMemoryHandlerTest extends TestCase
{
    private string $memoryId;
    protected function setUp(): void
    {
        parent::setUp();
        $this->memoryId = '0379688f-2983-4a16-b2de-ad3976d540da';
    }

    public function test_deleteMemory_deletes_memory()
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->expects($spy = self::any())->method('delete')->with(Uuid::fromValue($this->memoryId));

        $handler = new DeleteMemoryHandler($repository);
        $command = new DeleteMemoryCommand($this->memoryId);
        $handler->execute($command);

        $this->assertTrue($spy->hasBeenInvoked());
    }
}
