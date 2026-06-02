<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging;

use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Contracts\Logging\LogFormatterInterface;
use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;

final class StructuredLogger implements LoggerInterface
{
    public function __construct(
        private readonly LogFormatterInterface $formatter,
        private readonly LogWriterInterface $writer,
    ) {
    }

    public function write(DiagnosticEntry $entry): void
    {

        $payload = $this->formatter->format($entry);
        $this->writer->write($payload);
    }
}
