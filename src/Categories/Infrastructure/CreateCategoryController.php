<?php

namespace App\Categories\Infrastructure;

use App\Categories\Application\CreateCategory\CreateCategoryCommand;
use App\Categories\Application\CreateCategory\CreateCategoryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateCategoryController extends AbstractController
{
    public function __construct(private readonly CreateCategoryHandler $handler)
    {

    }

    #[Route('/categories', methods: ['POST'])]
    public  function  createCategory(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $command = new CreateCategoryCommand($data['name']);

        $this->handler->execute($command);
        return new Response('', Response::HTTP_CREATED);
    }
}