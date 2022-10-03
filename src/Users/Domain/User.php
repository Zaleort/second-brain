<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\EmailAddress;
use App\Shared\Domain\Entity;
use App\Shared\Domain\UuidValueObject;

class User extends Entity
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly EmailAddress $email,
        private readonly Password $password,
    ) {
    }

    public static function create(
        UuidValueObject $id,
        EmailAddress $email,
        Password $password,
    ): self {
        return new self($id, $email, $password);
    }

    public function getId(): UuidValueObject
    {
        return $this->id;
    }

    public function getEmail(): EmailAddress
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}