<?php

namespace App\Memories\Infrastructure;

use App\Memories\Application\CreateMemory\CreateMemoryCommand;
use App\Memories\Application\CreateMemory\CreateMemoryHandler;
use App\Memories\Domain\SameTypeAndNameException;
use App\Shared\Domain\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateMemoryController extends AbstractController
{
    public function __construct(
        private readonly CreateMemoryHandler $handler,
        private readonly UuidGenerator $uuidGenerator,
    ) {}

    #[Route('/memories', methods: ['POST'])]
    public function createMemory(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $id = $this->uuidGenerator->random();
        $command = new CreateMemoryCommand(
            $id,
            $data['name'],
            $data['type'],
            $data['categories'],
            $data['content'],
        );

        try {
            $this->handler->execute($command);
            return new Response('', Response::HTTP_CREATED);
        } catch (SameTypeAndNameException $error) {
            return new JsonResponse(['error' => $error->getMessage()], Response::HTTP_CONFLICT);
        }

    }
}