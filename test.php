<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;

$app = new Application();

$kernel = new Kernel($app);

$kernel->bootstrap();

print_r(
    $app->get('kernel.bootstrappers.executed')
);