<?php

declare(strict_types=1);

namespace App\Users\Infrastructure;

use App\Categories\Domain\CustomException;
use App\Shared\Infrastructure\PublicController;
use App\Users\Application\Login\LoginCommand;
use App\Users\Application\Login\LoginHandler;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LoginController extends AbstractController implements PublicController
{
    public function __construct(
        private readonly LoginHandler $handler,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * @throws JsonException
     */
    #[Route('/login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $command = new LoginCommand(
            $data['email'],
            $data['password'],
        );

        try {
            $result = $this->handler->execute($command);
            return JsonResponse::fromJsonString($this->serializer->serialize($result, 'json'));
        } catch (CustomException $exception) {
            return new Response($exception->getMessage(), $exception->getHttpCode());
        }
    }
}