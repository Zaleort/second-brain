<?php

declare(strict_types=1);

namespace App\Users\Infrastructure;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\EmailAddress;
use App\Shared\Domain\InvalidEmailException;
use App\Shared\Domain\UuidValueObject;
use App\Users\Domain\Password;
use App\Users\Domain\User;
use App\Users\Domain\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @throws InvalidEmailException
     * @throws CustomException
     */
    public function findByEmail(EmailAddress $email): ?User
    {
        return new User(
            UuidValueObject::fromValue("13eade5a-d7a3-47fb-8a5e-a2d65f43122d"),
            EmailAddress::fromValue('henrique@brokalia.com'),
            new Password('pass'),
        );
    }

    /**
     * @throws InvalidEmailException
     * @throws CustomException
     */
    public function findById(UuidValueObject $id): ?User
    {
        return new User(
            UuidValueObject::fromValue("13eade5a-d7a3-47fb-8a5e-a2d65f43122d"),
            EmailAddress::fromValue('henrique@brokalia.com'),
            new Password('pass'),
        );
    }
}