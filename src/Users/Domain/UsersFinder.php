<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\EmailAddress;
use App\Shared\Domain\InvalidEmailException;

class UsersFinder
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    /**
     * @throws InvalidEmailException
     * @throws CustomException
     */
    public function getUserOrThrow(string $email): \App\Users\Domain\User
    {
        $user = $this->repository->findByEmail(EmailAddress::fromValue($email));
        if (!$user) {
            throw new CustomException('Usuario o contraseña incorrecto', 401);
        }
        return $user;
    }
}