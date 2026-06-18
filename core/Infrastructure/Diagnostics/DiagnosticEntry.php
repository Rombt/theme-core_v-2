<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticEntry
{
    /**
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        private readonly DiagnosticLevel $level,
        private readonly string $message,
        private readonly DiagnosticContext $context,
        private readonly array $metadata,
        private readonly \DateTimeImmutable $timestamp,
    ) {
    }

    public function level(): DiagnosticLevel
    {
        return $this->level;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function context(): DiagnosticContext
    {
        return $this->context;
    }

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }

    public function timestamp(): \DateTimeImmutable
    {
        return $this->timestamp;
    }
}
