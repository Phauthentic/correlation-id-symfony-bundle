<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\EventSubscriber;

use InvalidArgumentException;
use Exception;
use Phauthentic\Infrastructure\Utils\CorrelationID;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CorrelationIdSubscriber implements EventSubscriberInterface
{
    private string $requestHeaderName = 'X-Correlation-ID';
    private string $responseHeaderName = 'X-Correlation-ID';
    private bool $passthrough = false;

    /**
     * @param array<string, mixed> $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        if (isset($config['request_header_name'])) {
            $this->requestHeaderName = (string)$config['request_header_name'];
        }

        if (isset($config['response_header_name'])) {
            $this->responseHeaderName = (string)$config['response_header_name'];
        }

        if (isset($config['pass_through'])) {
            $this->passthrough = (bool)$config['pass_through'];
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $event->getRequest()->attributes->set($this->requestHeaderName, CorrelationID::toString());
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @param ResponseEvent $event
     * @return void
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (
            $this->passthrough
            && $event->getRequest()->headers->has($this->requestHeaderName)
        ) {
            $event->getResponse()->headers->set(
                $this->responseHeaderName,
                $event->getRequest()->headers->get($this->requestHeaderName)
            );

            return;
        }

        $event->getResponse()->headers->set($this->responseHeaderName, CorrelationID::toString());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 255],
            KernelEvents::RESPONSE => ['onKernelResponse', -255]
        ];
    }
}
