<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Result;

use Rombt\ThemeCore\Runtime\Context\ExecutionContext;

final class StageResult
{
    public function __construct(
        private string $stageName,
        private bool $success,
        private ExecutionContext $context,
        private float $startedAt,
        private float $finishedAt,
        private ?\Throwable $error = null,
        private array $metadata = []
    ) {
    }

    public function getStageName(): string
    {
        return $this->stageName;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getContext(): ExecutionContext
    {
        return $this->context;
    }

    public function getDuration(): float
    {
        return $this->finishedAt - $this->startedAt;
    }

    public function getError(): ?\Throwable
    {
        return $this->error;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }
}
