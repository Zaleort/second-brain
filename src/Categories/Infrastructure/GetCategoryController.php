<?php

namespace App\Categories\Infrastructure;

use App\Categories\Application\GetCategory\GetCategoryCommand;
use App\Categories\Application\GetCategory\GetCategoryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetCategoryController extends AbstractController
{
    public function __construct(
        private readonly GetCategoryHandler $handler,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    #[Route('/categories/{name}', methods: ['GET'])]
    public function getCategory(string $name): Response
    {
        $command = new GetCategoryCommand($name);
        $category = $this->handler->execute($command);
        if (!$category)
        {
            throw $this->createNotFoundException('DoctrineCategory not found for name '.$name);
        }

        return JsonResponse::fromJsonString($this->serializer->serialize(
            $category,
            'json',
            ['groups' => ['category']]
        ));
    }
}