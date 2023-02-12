<?php

namespace App\Users\Domain;

use App\Shared\Domain\EmailAddress;

interface UserRepositoryInterface
{
    public function findByEmail(EmailAddress $email): ?User;

    public function findById(UserId $id): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;

    public function save(User $user): void;
}