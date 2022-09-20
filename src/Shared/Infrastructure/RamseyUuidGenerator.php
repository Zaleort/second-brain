<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\UuidGenerator;
use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidGenerator
{
    public function random(): string
    {
        return Uuid::uuid4()->toString();
    }
}