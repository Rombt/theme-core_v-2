<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging;

use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;

interface LoggerInterface
{
    public function write(DiagnosticEntry $entry): void;
}
