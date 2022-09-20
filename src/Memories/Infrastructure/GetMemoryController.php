<?php

namespace App\Memories\Infrastructure;

use App\Categories\Domain\CustomException;
use App\Memories\Application\GetMemory\GetMemoryCommand;
use App\Memories\Application\GetMemory\GetMemoryHandler;
use App\Memories\Domain\MemoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetMemoryController extends AbstractController
{
    public function __construct(private readonly GetMemoryHandler $handler, private readonly SerializerInterface $serializer)
    {
    }

    #[Route('/memories/{id}', methods: ['GET'])]
    public function getMemory(string $id): Response
    {
        try {
            $command = new GetMemoryCommand($id);
            $memory = $this->handler->execute($command);

            return JsonResponse::fromJsonString($this->serializer->serialize($memory, 'json'));
        } catch (CustomException $error) {
            return new JsonResponse(['error' => $error->getMessage()], $error->getHttpCode());
        }
    }
}