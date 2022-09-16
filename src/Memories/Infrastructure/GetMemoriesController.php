<?php

namespace App\Memories\Infrastructure;

use App\Memories\Application\GetMemories\GetMemoriesHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetMemoriesController extends AbstractController
{
    public function __construct(private readonly GetMemoriesHandler $handler, private readonly SerializerInterface $serializer)
    {
    }

    #[Route('/memories', methods: ['GET'])]
    public function getMemories(): Response
    {
        $memories = $this->handler->execute();
        return JsonResponse::fromJsonString($this->serializer->serialize($memories, 'json'));
    }
}
