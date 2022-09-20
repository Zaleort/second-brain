<?php

namespace App\Memories\Domain;

use App\Shared\Domain\UuidValueObject;

class MemoryCategories
{
    private array $categories = [];
    public function __construct()
    {
    }

    public function add(UuidValueObject $categoryId): void
    {
        $this->categories[] = $categoryId;
    }

    /**
     * @return UuidValueObject[]
     */
    public function getValues(): array
    {
        return $this->categories;
    }
}