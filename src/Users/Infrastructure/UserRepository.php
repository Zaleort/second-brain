<?php

declare(strict_types=1);

namespace App\Users\Infrastructure;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\EmailAddress;
use App\Shared\Domain\InvalidEmailException;
use App\Shared\Domain\UuidValueObject;
use App\Users\Domain\User;
use App\Users\Domain\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws InvalidEmailException
     * @throws CustomException
     */
    public function findByEmail(EmailAddress $email): ?User
    {
        $doctrineUser = $this->entityManager->getRepository(DoctrineUser::class)->findOneBy(['email' => $email->value]);
        if (!$doctrineUser) {
            return null;
        }

        return User::fromPrimitives(
            $doctrineUser->id,
            $doctrineUser->email,
            $doctrineUser->password,
        );
    }

    /**
     * @throws InvalidEmailException
     * @throws CustomException
     */
    public function findById(UuidValueObject $id): ?User
    {
        $repository = $this->entityManager->getRepository(DoctrineUser::class);
        $doctrineUser = $repository->find($id->value);
        if (!$doctrineUser) {
            return null;
        }

        return User::fromPrimitives(
            $doctrineUser->id,
            $doctrineUser->email,
            $doctrineUser->password,
        );
    }
}