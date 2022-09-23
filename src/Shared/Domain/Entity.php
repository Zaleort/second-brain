<?php

namespace App\Shared\Domain;

class Entity
{
    protected array $events = [];

    public function getEvents(): array
    {
        return $this->events;
    }
}