<?php

namespace App\Tests\unit\Memories\Domain;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\MemoryContent;
use App\Tests\Mothers\MemoryMother;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{

    /**
     * @throws CustomException
     */
    public function test_updateContent_updates_content(): void
    {
        $memory = MemoryMother::random();
        $date = $memory->getModifiedAt();
        $memory->updateContent(MemoryContent::fromValue('Content'));

        $this->assertEquals('Content', $memory->getContent()->value);
        $this->assertNotEquals($date, $memory->getModifiedAt());
    }

    /**
     * @throws CustomException
     */
    public function test_updateContent_throws_exception_given_invalid_content(): void
    {
        $memory = MemoryMother::random();
        $this->expectException(CustomException::class);
        $memory->updateContent(MemoryContent::fromValue('Exception'));
    }
}