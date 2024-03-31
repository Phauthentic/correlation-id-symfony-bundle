<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\Messenger\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

/**
 *
 */
class CorrelationIdStamp implements StampInterface
{
    private string $correlationId;

    public function __construct(string $correlationId)
    {
        $this->correlationId = $correlationId;
    }

    public function getCorrelationId(): string
    {
        return $this->correlationId;
    }
}
