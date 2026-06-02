<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Formatters;

use JsonException;
use Rombt\ThemeCore\Contracts\Logging\LogFormatterInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;

final class JsonFormatter implements LogFormatterInterface
{
    public function format(
        DiagnosticEntry $entry
    ): string {

        return json_encode(
            [
                'level' => $entry->level()->value,
                'timestamp' => $entry->timestamp()->format(DATE_ATOM),
                'message' => $entry->message(),
                'context' => $entry->context()->all(),
                'metadata' => $entry->metadata(),
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
