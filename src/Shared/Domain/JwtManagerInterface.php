<?php

namespace App\Shared\Domain;

interface JwtManagerInterface
{
    public function encode(JwtPayload $payload): string;

    public function decode(string $token): JwtPayload;
}