<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\TestsEventSubscriber;

use PHPUnit\Framework\TestCase;
use Phauthentic\CorrelationIdBundle\EventSubscriber\CorrelationIdSubscriber;
use Phauthentic\Infrastructure\Utils\CorrelationID;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CorrelationIdSubscriberTest extends TestCase
{
    private const CORRELATION_ID = 'd8d089ec-72c8-44c1-a0bf-1906e5fc3524';

    public function setUp(): void
    {
        $reflection = new ReflectionClass(CorrelationID::class);
        $reflection->setStaticPropertyValue('value', self::CORRELATION_ID);

        parent::setUp();
    }

    public function testOnKernelRequest(): void
    {
        $request = new Request();
        $request->headers->set('X-Correlation-ID', self::CORRELATION_ID);

        $requestEvent = new RequestEvent(
            $this->createMock(\Symfony\Component\HttpKernel\HttpKernelInterface::class),
            $request,
            null
        );

        $subscriber = new CorrelationIdSubscriber();
        $subscriber->onKernelRequest($requestEvent);

        $this->assertNotEmpty($request->attributes->get('X-Correlation-ID'));
        $this->assertSame(self::CORRELATION_ID, $request->attributes->get('X-Correlation-ID'));
    }

    public function testOnKernelResponse(): void
    {
        $response = new Response();

        $responseEvent = new ResponseEvent(
            $this->createMock(\Symfony\Component\HttpKernel\HttpKernelInterface::class),
            new Request(),
            1,
            $response
        );

        $subscriber = new CorrelationIdSubscriber();
        $subscriber->onKernelResponse($responseEvent);

        $this->assertNotEmpty($response->headers->get('X-Correlation-ID'));
    }

    public function testGetSubscribedEvents(): void
    {
        $subscribedEvents = CorrelationIdSubscriber::getSubscribedEvents();

        $this->assertIsArray($subscribedEvents);
        $this->assertArrayHasKey(KernelEvents::REQUEST, $subscribedEvents);
        $this->assertSame(['onKernelRequest', 255], $subscribedEvents[KernelEvents::REQUEST]);
        $this->assertArrayHasKey(KernelEvents::RESPONSE, $subscribedEvents);
        $this->assertSame(['onKernelResponse', -255], $subscribedEvents[KernelEvents::RESPONSE]);
    }
}
