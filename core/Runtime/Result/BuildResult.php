<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Result;

final class BuildResult
{
    private string $status;

    private ?\Throwable $error;

    /**
     * @var array<string, mixed>
     */
    private array $metadata;

    /**
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        string $status,
        ?\Throwable $error = null,
        array $metadata = []
    ) {
        $this->status = $status;
        $this->error = $error;
        $this->metadata = $metadata;
    }

    public function getStatus(): string
    {
        return $this->status;
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
