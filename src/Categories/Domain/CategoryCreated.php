<?php

namespace App\Categories\Domain;

class CategoryCreated
{
    public function __construct(public readonly string $id)
    {
    }
}