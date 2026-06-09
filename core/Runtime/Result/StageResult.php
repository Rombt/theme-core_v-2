<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Result;

final class StageResult
{
    /**
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        private bool $success,
        private ?\Throwable $error = null,
        private array $metadata = []
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getError(): ?\Throwable
    {
        return $this->error;
    }

    /**
     * @return array<string, mixed>
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }
}
