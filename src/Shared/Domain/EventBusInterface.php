<?php

namespace App\Shared\Domain;

interface EventBusInterface
{
    public function dispatch($event): void;
    public function dispatchAll(array $events): void;
}