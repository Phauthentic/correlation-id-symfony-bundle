<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\EventSubscriber;

use Phauthentic\Infrastructure\Utils\CorrelationID;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CorrelationIdSubscriber implements EventSubscriberInterface
{
    private string $header = 'X-Correlation-ID';

    public function onKernelRequest(RequestEvent $event): void
    {
        $event->getRequest()->attributes->set($this->header, CorrelationID::toString());
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if ($event->getRequest()->headers->has($this->header)) {
            $event->getResponse()->headers->set(
                $this->header,
                $event->getRequest()->headers->get($this->header)
            );

            return;
        }

        $event->getResponse()->headers->set($this->header, CorrelationID::toString());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 255],
            KernelEvents::RESPONSE => ['onKernelResponse', -255]
        ];
    }
}
