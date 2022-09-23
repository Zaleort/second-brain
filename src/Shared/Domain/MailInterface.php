<?php

namespace App\Shared\Domain;

interface MailInterface
{
    public function send(string $to, string $subject, string $content): void;
}