<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticsService
{
    public function __construct(
        private readonly DiagnosticCollector $collector,
    ) {
    }

    public function create(
        DiagnosticLevel $level,
        string $message,
        DiagnosticContext $context,
        array $metadata = [],
    ): DiagnosticEntry {

        $entry = new DiagnosticEntry(
            level: $level,
            message: $message,
            context: $context,
            metadata: $metadata,
            timestamp: new \DateTimeImmutable(),
        );

        $this->collector->record($entry);

        return $entry;
    }
}
