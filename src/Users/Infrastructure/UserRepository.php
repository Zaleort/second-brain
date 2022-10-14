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

    /**
     * @throws CustomException
     * @throws InvalidEmailException
     */
    public function findAll(): array
    {
        $repository = $this->entityManager->getRepository(DoctrineUser::class);
        $doctrineUsers = $repository->findAll();

        $users = [];
        foreach ($doctrineUsers as $doctrineUser) {
            $users[] = User::fromPrimitives(
                $doctrineUser->id,
                $doctrineUser->email,
                $doctrineUser->password,
            );
        }

        return $users;
    }

    public function save(User $user): void
    {
        $doctrineUser = $this->entityManager->find(
            DoctrineUser::class,
            $user->getId()->value
        ) ?? new DoctrineUser();

        $doctrineUser->id = $user->getId()->value;
        $doctrineUser->email = $user->getEmail()->value;
        $doctrineUser->password = $user->getPassword()->value;

        $this->entityManager->persist($doctrineUser);
        $this->entityManager->flush();
    }
}