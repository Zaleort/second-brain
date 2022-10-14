<?php

declare(strict_types=1);

namespace App\Users\Application\Login;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\EmailAddress;
use App\Shared\Domain\InvalidEmailException;
use App\Shared\Domain\JwtManagerInterface;
use App\Shared\Domain\JwtPayload;
use App\Users\Domain\User;
use App\Users\Domain\UserRepositoryInterface;

class LoginHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JwtManagerInterface $jwtManager,
    ) {
    }

    /**
     * @throws CustomException
     */
    public function execute(LoginCommand $command): LoginResult
    {
        $user = $this->getUserOrThrow($command->email);
        $this->checkPasswordOrThrow($user, $command->password);
        $token = $this->jwtManager->encode(new JwtPayload($user->getId()->value));
        return new LoginResult($token);
    }

    /**
     * @throws InvalidEmailException
     * @throws CustomException
     */
    private function getUserOrThrow(string $email): \App\Users\Domain\User
    {
        $user = $this->userRepository->findByEmail(EmailAddress::fromValue($email));
        if (!$user) {
            throw new CustomException('Usuario o contraseña incorrecto', 401);
        }
        return $user;
    }

    /**
     * @throws CustomException
     */
    private function checkPasswordOrThrow(User $user, string $password): void
    {
        if (!$user->getPassword()->compare($password)) {
            throw new CustomException('Usuario o contraseña incorrecto', 401);
        }
    }
}