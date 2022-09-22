<?php

namespace App\Shared\Domain;

class Clock
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}