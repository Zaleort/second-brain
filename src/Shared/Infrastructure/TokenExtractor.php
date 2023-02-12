<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Request;

class TokenExtractor
{
    public function __construct()
    {
    }

    /**
     * @throws UnauthorizedException
     */
    public function getToken(Request $request): string
    {
        if ($request->headers->get('Authorization')) {
            // Remove "Bearer " at the beginning
            return substr($request->headers->get('Authorization'), 7);
        }

        if ($request->query->get('token')) {
            return $request->query->get('token');
        }

        throw new UnauthorizedException('Token not found');
    }
}
