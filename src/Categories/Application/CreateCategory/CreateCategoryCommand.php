<?php
declare(strict_types=1);
namespace App\Categories\Application\CreateCategory;

class CreateCategoryCommand
{
    public function __construct(public readonly string $name)
    {

    }
}