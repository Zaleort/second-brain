<?php

namespace App\Categories\Application\GetCategory;

class GetCategoryCommand
{
    public function __construct(public readonly string $name)
    {
    }
}