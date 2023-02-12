<?php

declare(strict_types=1);

namespace App\Users\Domain\UserFinder;

use App\Users\Domain\User;
use App\Users\Domain\UserEmail;
use App\Users\Domain\UserId;
use App\Users\Domain\UserRepositoryInterface;

class UsersFinder
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    /**
     * @throws UserNotFound
     */
    public function getUserByEmail(UserEmail $email): User
    {
        $user = $this->repository->findByEmail($email);
        if (!$user) {
            throw new UserNotFound();
        }

        return $user;
    }

    /**
     * @throws UserNotFound
     */
    public function getUserById(UserId $id): User
    {
        $user = $this->repository->findById($id);
        if (!$user) {
            throw new UserNotFound();
        }

        return $user;
    }
}