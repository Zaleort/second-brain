<?php

namespace App\Tests\Mothers;

use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryCategories;
use App\Memories\Domain\MemoryName;
use App\Memories\Domain\MemoryType;
use App\Shared\Domain\UuidValueObject;
use App\Shared\Infrastructure\RamseyUuidGenerator;

class MemoryMother
{
    public static function random(): Memory
    {
        $uuid = new RamseyUuidGenerator();

        $memory = Memory::create(
            UuidValueObject::fromValue($uuid->random()),
            MemoryName::fromValue('Name'),
            MemoryType::text(),
            new \DateTimeImmutable(),
            new MemoryCategories(),
            UuidValueObject::fromValue($uuid->random()),
            null,
        );

        $memory->clearEvents();
        return $memory;
    }

    public static function withId(string $id): Memory
    {
        $uuid = new RamseyUuidGenerator();
        $memory = Memory::create(
            UuidValueObject::fromValue($id),
            MemoryName::fromValue('Name'),
            MemoryType::text(),
            new \DateTimeImmutable(),
            new MemoryCategories(),
            UuidValueObject::fromValue($uuid->random()),
            null,
        );

        $memory->clearEvents();
        return $memory;
    }
}