<?php

declare(strict_types=1);

namespace App\Memories\Domain\ForbiddenWords;

use App\Categories\Domain\ForbiddenNameException;

class ForbiddenWordChecker
{
    public function __construct(private readonly ForbiddenWordsRepositoryInterface $forbiddenWordsRepository)
    {
    }

    /**
     * @throws ForbiddenNameException
     */
    public function assert(string|null $content): void
    {
        if (!$content) {
            return;
        }

        $words = $this->forbiddenWordsRepository->findAll();
        foreach ($words as $word) {
            if (str_contains($content, $word->getWord())) {
                throw new ForbiddenNameException();
            }
        }
    }
}