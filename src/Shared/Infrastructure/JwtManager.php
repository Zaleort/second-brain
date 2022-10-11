<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\JwtManagerInterface;
use App\Shared\Domain\JwtPayload;
use Firebase\JWT\JWT;

class JwtManager implements JwtManagerInterface
{
    public function encode(JwtPayload $payload): string
    {
        return JWT::encode(['id' => $payload->id], 'Buenas tardes', 'HS256');
    }

    public function decode(string $token): JwtPayload
    {
        return new JwtPayload($token);
    }
}