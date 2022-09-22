<?php

namespace App\Memories\Infrastructure;

use App\Memories\Application\DeleteMemory\DeleteMemoryCommand;
use App\Memories\Application\DeleteMemory\DeleteMemoryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteMemoryController extends AbstractController
{
    public function __construct(private readonly DeleteMemoryHandler $handler)
    {
    }

    #[Route('/memories/{id}', methods: ['DELETE'])]
    public function deleteMemory(string $id): Response
    {
        $command = new DeleteMemoryCommand($id);
        $this->handler->execute($command);

        return new Response('', Response::HTTP_OK);
    }
}