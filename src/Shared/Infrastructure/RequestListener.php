<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Exceptions\CustomException;
use App\Users\Domain\UserId;
use App\Users\Infrastructure\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    public function __construct(
        private readonly UserRepository  $userRepository,
        private readonly JwtManager      $jwtManager,
        private readonly TokenExtractor  $tokenExtractor,
        private readonly LoggerInterface $logger,
    )
    {
    }

    #[AsEventListener]
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
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

        $token = $this->tokenExtractor->getToken($event->getRequest());
        $payload = $this->jwtManager->decode($token);
        $user = $this->userRepository->findById(UserId::fromValue($payload->id));

        $event->getRequest()->server->set('user', $user);
    }

    #[AsEventListener]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'trace' => $_ENV['APP_ENV'] === 'dev' ? $exception->getTrace() : null,
        ], $exception instanceof CustomException ? $exception->getHttpCode() : 500);

        $event->setResponse($response);

        $this->logger->error($exception->getFile() . ' ' . $exception->getLine());
    }
}