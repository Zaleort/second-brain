<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\UuidValueObject;
use App\Users\Domain\UserRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @throws CustomException
     */
    #[AsEventListener]
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = is_array($event->getController()) ? $event->getController()[0] : $event->getController();
        if ($controller instanceof PublicController) {
            return;
        }

        $token = $event->getRequest()->query->get('token');
        if (!$token) {
            throw new CustomException('Token required', 401);
        }

        $user = $this->userRepository->findById(UuidValueObject::fromValue($token));

        if (!$user) {
            throw new CustomException('Unauthorized', 401);
        }

        $event->getRequest()->server->set('user', $user);
    }

    #[AsEventListener]
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
    }

    #[AsEventListener]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse([
            'message' => $exception->getMessage()
        ], $exception instanceof CustomException ? $exception->getHttpCode() : 500);

        $event->setResponse($response);

        $this->logger->error($exception->getFile() . ' ' . $exception->getLine());
    }
}