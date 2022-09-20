<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\UuidGenerator;
use Symfony\Component\Uid\Uuid;

class SymfonyUuidGenerator implements UuidGenerator
{
    public function random(): string
    {
        return Uuid::v4()->toRfc4122();
    }

}