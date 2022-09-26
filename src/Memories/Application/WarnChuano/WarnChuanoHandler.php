<?php

namespace App\Memories\Application\WarnChuano;

use App\Categories\Domain\CustomException;
use App\Memories\Domain\MemoryRepositoryInterface;
use App\Shared\Domain\MailInterface;
use App\Shared\Domain\UuidValueObject;

class WarnChuanoHandler
{
    public function __construct(
        private readonly MemoryRepositoryInterface $repository,
        private readonly MailInterface $mail,
    ) {
    }

    public function execute(WarnChuanoCommand $command): void
    {
        $memory = $this->repository->findById(UuidValueObject::fromValue($command->id));
        if (!$memory) {
            throw new CustomException('Memory not found', 404);
        }

        if (str_contains($memory->getContent()->value, 'Chuano')) {
            $this->mail->send('juanjo@brokalia.com', 'Te mencionan', 'Te mencionan en este ID: ' . $command->id);
        }
    }
}