<?php

declare(strict_types=1);

use Rombt\ThemeCore\Infrastructure\Logging\StructuredLogger;

$app = require dirname(__DIR__) . '/core/bootstrap/application.php';

$runtime = $app->get('composition.runtime');

$logger = $runtime
    ->services()
    ->get(StructuredLogger::class);

var_dump($logger);
