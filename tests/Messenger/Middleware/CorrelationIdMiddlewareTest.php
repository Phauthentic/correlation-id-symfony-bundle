<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\Tests\Messenger\Middleware;

use Phauthentic\CorrelationIdBundle\Messenger\Middleware\CorrelationIdMiddleware;
use Phauthentic\CorrelationIdBundle\Messenger\Stamp\CorrelationIdStamp;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\StackMiddleware;

/**
 *
 */
class CorrelationIdMiddlewareTest extends TestCase
{
    public function testHandle(): void
    {
        $middleware = new CorrelationIdMiddleware();
        $envelope = new Envelope(new stdClass());
        $stack = new StackMiddleware();

        $envelope = $middleware->handle($envelope, $stack);

        $this->assertArrayHasKey(CorrelationIdStamp::class, $envelope->all());
    }
}
