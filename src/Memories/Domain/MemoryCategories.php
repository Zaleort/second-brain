<?php

namespace App\Memories\Domain;

use App\Shared\Domain\Exceptions\CustomException;
use App\Shared\Domain\Uuid;

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
            $memoryCategories->add(Uuid::fromValue($categoryId));
        }

        return $memoryCategories;
    }

    public function add(Uuid $categoryId): void
    {
        $this->categories[] = $categoryId;
    }

    /**
     * @return Uuid[]
     */
    public function getValues(): array
    {
        return $this->categories;
    }
}