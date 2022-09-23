<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\EventBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerEventBus implements EventBusInterface
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function dispatch($event): void
    {
        $this->messageBus->dispatch($event);
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }
}