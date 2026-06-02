<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Contracts\Logging;

use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;

interface LogFormatterInterface
{
    public function format(
        DiagnosticEntry $entry
    ): string;
}
