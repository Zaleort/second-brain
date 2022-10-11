<?php

namespace App\Memories\Domain;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\UuidValueObject;

class MemoryCategories
{
    private array $categories = [];

    public function __construct()
    {
    }

    /**
     * @throws CustomException
     */
    public static function fromArray(array $categories): self
    {
        $memoryCategories = new self();
        foreach ($categories as $categoryId) {
            $memoryCategories->add(UuidValueObject::fromValue($categoryId));
        }

        return $memoryCategories;
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