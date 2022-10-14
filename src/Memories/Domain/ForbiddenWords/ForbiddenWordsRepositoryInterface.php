<?php

namespace App\Memories\Domain\ForbiddenWords;

interface ForbiddenWordsRepositoryInterface
{
    /**
     * @return ForbiddenWord[]
     */
    public function findAll(): array;
}