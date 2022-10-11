<?php

declare(strict_types=1);

namespace App\Shared\Domain;

class JwtPayload
{
    public function __construct(public readonly string $id)
    {
    }
}