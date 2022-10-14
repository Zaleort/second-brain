<?php

declare(strict_types=1);

namespace App\Memories\Domain\ForbiddenWords;

class ForbiddenWord
{
    public function __construct(private readonly string $id, private readonly string $word)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getWord(): string
    {
        return $this->word;
    }
}