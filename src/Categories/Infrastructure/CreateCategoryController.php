<?php

namespace App\Categories\Infrastructure;

use App\Categories\Application\CreateCategory\CategoryAlreadyExistsException;
use App\Categories\Application\CreateCategory\CreateCategoryCommand;
use App\Categories\Application\CreateCategory\CreateCategoryHandler;
use App\Categories\Domain\CustomException;
use App\Categories\Domain\ForbiddenNameException;
use App\Shared\Domain\UuidGenerator;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateCategoryController extends AbstractController
{
    public function __construct(private readonly CreateCategoryHandler $handler, private readonly UuidGenerator $uuidGenerator)
    {

    }

    #[Route('/categories', methods: ['POST'])]
    public  function  createCategory(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $command = new CreateCategoryCommand($this->uuidGenerator->random(), $data['name']);

        try {
            $this->handler->execute($command);
            return new Response('', Response::HTTP_CREATED);
        } catch (CustomException $error) {
            return new JsonResponse(['error' => $error->getMessage()], $error->getHttpCode());
        } catch (Exception $error) {
            return new JsonResponse(['error' => 'Error desconocido'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}