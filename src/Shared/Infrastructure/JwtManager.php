<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\JwtManagerInterface;
use App\Shared\Domain\JwtPayload;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtManager implements JwtManagerInterface
{
    public function encode(JwtPayload $payload): string
    {
        return JWT::encode(['id' => $payload->id], 'Buenas tardes', 'HS256');
    }

    public function decode(string $token): JwtPayload
    {
        $key = new Key('Buenas tardes', 'HS256');
        $decoded = JWT::decode($token, $key);

        return new JwtPayload($decoded->id);
    }
}