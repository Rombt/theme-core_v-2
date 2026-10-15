<?php

declare(strict_types=1);

require dirname(__DIR__) . '/core/bootstrap/application.php';

if (
    getenv('TEMPLIX_BUILD_PROTOCOL') === '1'
    && isset($result)
    && $result instanceof \Rombt\ThemeCore\Runtime\Result\BuildResult
) {
    $error = $result->getError();

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
                'metadata' => (object) $result->getMetadata(),
            ],
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        ) . PHP_EOL,
    );
}
