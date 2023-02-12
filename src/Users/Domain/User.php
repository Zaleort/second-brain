<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\Entity;
use App\Shared\Domain\Exceptions\CustomException;
use App\Shared\Domain\Exceptions\InvalidEmailException;

class User extends Entity
{
    private function __construct(
        private readonly UserId       $id,
        private readonly UserEmail    $email,
        private readonly UserPassword $password,
    )
    {
    }

    public static function create(
        UserId       $id,
        UserEmail    $email,
        UserPassword $password,
    ): self
    {
        return new self($id, $email, $password);
    }

    /**
     * @throws InvalidEmailException
     * @throws CustomException
     */
    public static function fromPrimitives(
        string $id,
        string $email,
        string $password,
    ): self
    {
        return new self(
            UserId::fromValue($id),
            UserEmail::fromValue($email),
            UserPassword::fromValue($password),
        );
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }
}