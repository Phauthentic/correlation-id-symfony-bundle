<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\Messenger\Middleware;

use Phauthentic\CorrelationIdBundle\Messenger\Stamp\CorrelationIdStamp;
use Phauthentic\Infrastructure\Utils\CorrelationID;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

/**
 *
 */
class CorrelationIdMiddleware implements MiddlewareInterface
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @throws \Exception
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (isset($envelope->all()[CorrelationIdStamp::class])) {
            return $stack->next()->handle($envelope, $stack);
        }

        $envelope = $envelope->with(
            new CorrelationIdStamp(CorrelationID::toString())
        );

        return $stack->next()->handle($envelope, $stack);
    }
}
