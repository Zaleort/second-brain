<?php

namespace App\Users\Domain;

use App\Shared\Domain\EmailAddress;
use App\Shared\Domain\UuidValueObject;

interface UserRepositoryInterface
{
    public function findByEmail(EmailAddress $email): ?User;

    public function findById(UuidValueObject $id): ?User;
}