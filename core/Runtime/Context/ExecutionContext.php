<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Context;

final class ExecutionContext
{
    public function __construct(
        private string $sessionId,
        private float $startedAt
    ) {
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getStartedAt(): float
    {
        return $this->startedAt;
    }
}
