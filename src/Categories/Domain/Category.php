<?php

namespace App\Categories\Domain;

class Category
{
    public function __construct(private readonly string $name, private readonly ?int $id = null)
    {
    }

    /**
     * @throws ForbiddenNameException
     */
    public static function create(string $name): self
    {
        if ($name === 'Brokalia') {
            throw new ForbiddenNameException('El nombre no puede contener Brokalia');
        }
        return new self($name);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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