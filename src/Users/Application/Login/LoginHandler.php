<?php

declare(strict_types=1);

namespace App\Users\Application\Login;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\JwtManagerInterface;
use App\Shared\Domain\JwtPayload;
use App\Users\Domain\User;
use App\Users\Domain\UsersFinder;

class LoginHandler
{
    public function __construct(
        private readonly UsersFinder $usersFinder,
        private readonly JwtManagerInterface $jwtManager,
    ) {
    }

    /**
     * @throws CustomException
     */
    public function execute(LoginCommand $command): LoginResult
    {
        $user = $this->usersFinder->getUserOrThrow($command->email);
        $this->checkPasswordOrThrow($user, $command->password);
        $token = $this->jwtManager->encode(new JwtPayload($user->getId()->value));
        return new LoginResult($token);
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