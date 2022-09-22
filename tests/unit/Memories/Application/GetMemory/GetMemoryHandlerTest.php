<?php

namespace App\Tests\unit\Memories\Application\GetMemory;

use App\Categories\Domain\CustomException;
use App\Memories\Application\GetMemory\GetMemoryCommand;
use App\Memories\Application\GetMemory\GetMemoryHandler;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Memories\Domain\MemoryType;
use App\Shared\Domain\UuidValueObject;
use App\Tests\Mothers\MemoryMother;
use PHPUnit\Framework\TestCase;

class GetMemoryHandlerTest extends TestCase
{
    private Memory $memory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->memory = MemoryMother::random();
    }

    public function test_get_memory_given_id()
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->expects($spy = self::any())
            ->method('findById')
            ->with(UuidValueObject::fromValue($this->memory->getId()->value))
            ->willReturn($this->memory);

        $handler = new GetMemoryHandler($repository);
        $command = new GetMemoryCommand($this->memory->getId()->value);

        $handler->execute($command);
        $this->assertTrue($spy->hasBeenInvoked());
    }

    public function test_throws_exception_if_memory_does_not_exist()
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->method('findById')->willReturn(null);

        $handler = new GetMemoryHandler($repository);
        $command = new GetMemoryCommand($this->memory->getId()->value);

        $this->expectException(CustomException::class);
        $handler->execute($command);
    }
}