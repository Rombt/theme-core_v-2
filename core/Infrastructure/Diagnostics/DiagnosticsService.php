<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticsService
{
    public function create(
        DiagnosticLevel $level,
        string $message,
        DiagnosticContext $context,
        array $metadata = [],
    ): DiagnosticEntry {
        return new DiagnosticEntry(
            level: $level,
            message: $message,
            context: $context,
            metadata: $metadata,
            timestamp: new \DateTimeImmutable(),
        );
    }
}
