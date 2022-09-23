<?php

namespace App\Memories\Domain;

class ContentUpdated
{
    public function __construct(public readonly string $id)
    {
    }
}