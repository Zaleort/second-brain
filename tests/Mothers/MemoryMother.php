<?php

namespace App\Tests\Mothers;

use App\Memories\Domain\Memory;
use App\Memories\Domain\MemoryType;
use App\Shared\Domain\Exceptions\CustomException;
use App\Shared\Infrastructure\RamseyUuidGenerator;

class MemoryMother
{
    /**
     * @throws CustomException
     */
    public static function random(): Memory
    {
        $uuid = new RamseyUuidGenerator();
        return Memory::fromPrimitives(
            $uuid->random(),
            'Name',
            MemoryType::text()->value,
            new \DateTimeImmutable(),
            [],
            $uuid->random(),
            null,
        );
    }

    /**
     * @throws CustomException
     */
    public static function withId(string $id): Memory
    {
        $uuid = new RamseyUuidGenerator();
        return Memory::fromPrimitives(
            $id,
            'Name',
            MemoryType::text()->value,
            new \DateTimeImmutable(),
            [],
            $uuid->random(),
            null,
        );
    }
}