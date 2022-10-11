<?php

declare(strict_types=1);

namespace App\Users\Application\Login;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\EmailAddress;
use App\Shared\Domain\JwtManagerInterface;
use App\Shared\Domain\JwtPayload;
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
        $user = $this->userRepository->findByEmail(EmailAddress::fromValue($command->email));
        if (!$user || $user->getPassword()->value !== $command->password) {
            throw new CustomException('Usuario o contraseña incorrecto', 401);
        }

        $token = $this->jwtManager->encode(new JwtPayload($user->getId()->value));
        return new LoginResult($token);
    }
}