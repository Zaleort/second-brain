<?php

namespace App\Categories\Infrastructure;

use App\Categories\Application\GetCategories\GetCategoriesHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetCategoriesController extends AbstractController
{
    public function __construct(
        private readonly GetCategoriesHandler $handler,
        private readonly SerializerInterface  $serializer,
    ) {}

    #[Route('/categories', methods: ['GET'])]
    public function getCategories(): Response
    {
        $categories = $this->handler->execute();
        return JsonResponse::fromJsonString($this->serializer->serialize($categories, 'json'));
    }
}