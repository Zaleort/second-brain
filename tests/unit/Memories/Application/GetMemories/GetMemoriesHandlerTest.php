<?php

namespace App\Tests\unit\Memories\Application\GetMemories;

use App\Memories\Application\GetMemories\GetMemoriesHandler;
use App\Memories\Domain\MemoryRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetMemoriesHandlerTest extends TestCase
{
    public function test_get_memories()
    {
        $repository = $this->createMock(MemoryRepositoryInterface::class);
        $repository->expects($spy = self::any())->method('findAll')->willReturn([]);

        $handler = new GetMemoriesHandler($repository);
        $handler->execute();

        $this->assertTrue($spy->hasBeenInvoked());
    }
}