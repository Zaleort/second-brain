<?php

namespace App\Memories\Infrastructure;

use App\Memories\Application\WarnChuano\WarnChuanoCommand;
use App\Memories\Application\WarnChuano\WarnChuanoHandler;
use App\Memories\Domain\ContentUpdated;
use App\Memories\Domain\MemoryCreated;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class OnCreateOrUpdateMemoryContentWarnChuano
{
    public function __construct(private readonly WarnChuanoHandler $handler)
    {
    }

    public function __invoke(MemoryCreated | ContentUpdated $event): void
    {
        $command = new WarnChuanoCommand($event->id);
        $this->handler->execute($command);
    }
}