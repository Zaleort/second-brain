<?php

declare(strict_types=1);

namespace App\Memories\Infrastructure\ForbiddenWords;

use App\Memories\Domain\ForbiddenWords\ForbiddenWord;
use App\Memories\Domain\ForbiddenWords\ForbiddenWordsRepositoryInterface;

class ForbiddenWordsRepository implements ForbiddenWordsRepositoryInterface
{

    public function findAll(): array
    {
        return [new ForbiddenWord('', 'Chuano')];
    }
}