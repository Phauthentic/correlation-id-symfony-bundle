<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\Tests\Messenger\Stamp;

use Phauthentic\CorrelationIdBundle\Messenger\Stamp\CorrelationIdStamp;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class CorrelationIdStampTest extends TestCase
{
    public function testGetCorrelationId(): void
    {
        $stamp = new CorrelationIdStamp('foo');
        $this->assertEquals('foo', $stamp->getCorrelationId());
    }
}
