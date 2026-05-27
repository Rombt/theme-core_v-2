<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;

$app = new Application();

$bootstrapRegistry = new BootstrapRegistry();

$bootstrapRegistry->register(
    SetInternalEncodingBootstrapper::class
);

$kernel = new Kernel(
    $app,
    $bootstrapRegistry,
);

$kernel->bootstrap();

print_r(
    $app->get('kernel.bootstrappers.executed')
);