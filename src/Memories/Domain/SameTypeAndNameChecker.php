<?php

declare(strict_types=1);

namespace App\Memories\Domain;

class SameTypeAndNameChecker
{
    public function __construct(private readonly MemoryRepositoryInterface $memoryRepository)
    {
    }

    /**
     * @throws SameTypeAndNameException
     */
    public function assert(string $name, int $type): void
    {
        $memories = $this->memoryRepository->findByCriteria(['name' => $name, 'type' => $type]);
        if (count($memories) > 0) {
            throw new SameTypeAndNameException('No puede haber una memoria con el mismo nombre y tipo');
        }
    }

    /**
     * @throws SameTypeAndNameException
     */
    public function assertOtherThanCurrent(string $currentMemoryId, string $name, int $type): void
    {
        $memories = $this->memoryRepository->findByCriteria(['name' => $name, 'type' => $type]);
        foreach ($memories as $memory) {
            if ($memory->getId()->value !== $currentMemoryId) {
                throw new SameTypeAndNameException('No puede haber una memoria con el mismo nombre y tipo');
            }
        }
    }
}