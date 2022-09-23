<?php

namespace App\Memories\Application\SendEmailCongratulation;

use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\MailInterface;

class SendEmailCongratulationHandler
{
    public function __construct(private readonly MemoryRepositoryInterface $repository, private readonly MailInterface $mail)
    {
    }

    public function execute(): void
    {
        $memories = $this->repository->count();
        if ($memories >= 1) {
            $this->mail->send('henrique@brokalia.com', '¡Enhorabuena!', 'Es tu memoria número 100');
        }
    }
}