<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Categories\Domain\CustomException;
use App\Shared\Domain\UuidValueObject;
use App\Users\Domain\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @throws CustomException
     */
    #[AsEventListener]
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if ($controller[0] instanceof PublicController) {
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
}