<?php

declare(strict_types=1);

namespace App\Users\Infrastructure;

use App\Users\Domain\Password;
use App\Users\Domain\User;
use App\Users\Domain\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HashPasswordsCommand extends Command
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
        parent::__construct('app:hash_password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();
        foreach ($users as $user) {
            $password = Password::encode($user->getPassword()->value);
            $updatedUser = User::fromPrimitives(
                $user->getId()->value,
                $user->getEmail()->value,
                $password->value,
            );
            // $this->userRepository->save($updatedUser);
        }

        return 0;
    }
}