<?php

namespace App\Memories\Infrastructure;

use App\Memories\Application\SendEmailCongratulation\SendEmailCongratulationHandler;
use App\Memories\Domain\MemoryCreated;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class OnMemoryCreatedSendEmail
{
    public function __construct(private readonly SendEmailCongratulationHandler $handler)
    {
    }

    public function __invoke(MemoryCreated $memoryCreated): void
    {
        $this->handler->execute();
    }
}