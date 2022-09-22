<?php

namespace App\Memories\Infrastructure;

use App\Memories\Application\UpdateMemoryContent\UpdateMemoryContentCommand;
use App\Memories\Application\UpdateMemoryContent\UpdateMemoryContentHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateMemoryContentController extends AbstractController
{
    public function __construct(private readonly UpdateMemoryContentHandler $handler)
    {
    }

    #[Route('/memories/{id}/content', methods: ['PUT', 'PATCH'])]
    public function updateMemoryContent(Request $request, string $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $command = new UpdateMemoryContentCommand($id, $data['content']);
        $this->handler->execute($command);

        return new Response('', Response::HTTP_OK);
    }
}