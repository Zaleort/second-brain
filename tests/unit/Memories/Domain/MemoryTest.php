<?php

namespace App\Tests\unit\Memories\Domain;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryContent;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryType;
use App\Shared\Domain\UuidValueObject;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{

    /**
     * @throws CustomException
     */
    public function test_updateContent_updates_content(): void
    {
        $memory = Memory::create(
            UuidValueObject::fromValue('0379688f-2983-4a16-b2de-ad3976d540da'),
            MemoryName::fromValue(''),
            MemoryType::link(),
            new \DateTimeImmutable(),
            new MemoryCategories(),
            null,
        );

        $date = $memory->getModifiedAt();
        $memory->updateContent(MemoryContent::fromValue('Content'));

        $this->assertEquals('Content', $memory->getContent()->value);
        $this->assertNotEquals($date, $memory->getModifiedAt());
    }

    public function test_updateContent_throws_exception_given_invalid_content(): void
    {
        $memory = Memory::create(
            UuidValueObject::fromValue('0379688f-2983-4a16-b2de-ad3976d540da'),
            MemoryName::fromValue(''),
            MemoryType::link(),
            new \DateTimeImmutable(),
            new MemoryCategories(),
            null,
        );

        $this->expectException(CustomException::class);
        $memory->updateContent(MemoryContent::fromValue('Exception'));
    }
}