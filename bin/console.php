<?php

declare(strict_types=1);

require dirname(__DIR__) . '/core/bootstrap/application.php';

if (
    getenv('TEMPLIX_BUILD_PROTOCOL') === '1'
    && isset($result)
    && $result instanceof \Rombt\ThemeCore\Runtime\Result\BuildResult
) {
    $error = $result->getError();
    $diagnosticEntries = [];

    if ($result->getStatus() === 'failed' && isset($app)) {
        /** @var \Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService $diagnostics */
        $diagnostics = $app->getContext()->get(
            \Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys::DIAGNOSTICS,
        );

        foreach ($diagnostics->report()->entries() as $entry) {
            $diagnosticEntries[] = [
                'level' => $entry->level()->value,
                'message' => $entry->message(),
                'context' => (object) $entry->context()->all(),
                'metadata' => (object) $entry->metadata(),
                'timestamp' => $entry->timestamp()->format(DATE_ATOM),
            ];
        }
    }

    fwrite(
        STDOUT,
        'TEMPLIX_BUILD_RESULT=' . json_encode(
            [
                'status' => $result->getStatus(),
                'error' => $error === null
                    ? null
                    : [
                        'message' => $error->getMessage(),
                        'file' => $error->getFile(),
                        'line' => $error->getLine(),
                    ],
                'diagnostics' => [
                    'entries' => $diagnosticEntries,
                ],
                'metadata' => (object) $result->getMetadata(),
            ],
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR,
        ) . PHP_EOL,
    );
}
