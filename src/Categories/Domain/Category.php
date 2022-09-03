<?php

namespace App\Categories\Domain;

class Category
{
    public function __construct(private readonly string $name)
    {
    }

    public static function create(string $name): self
    {
        return new self($name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}