<?php

namespace App\Categories\Domain;

class Category
{
    public function __construct(private readonly string $id, private readonly string $name)
    {
    }

    /**
     * @throws ForbiddenNameException
     */
    public static function create(string $id, string $name): self
    {
        if ($name === 'Brokalia') {
            throw new ForbiddenNameException('El nombre no puede contener Brokalia');
        }
        return new self($id, $name);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}