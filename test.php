<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;

$app = new Application();

$bootstrapRegistry = new BootstrapRegistry();

$bootstrapRegistry->register(
    SetInternalEncodingBootstrapper::class
);

$bootstrapperFactory = new BootstrapperFactory();

$kernel = new Kernel(
    $app,
    $bootstrapRegistry,
    $bootstrapperFactory,
);

$kernel->bootstrap();

print_r([
    'status' => $app->get('kernel.bootstrap.status'),
    'current' => $app->get('kernel.bootstrap.current'),
    'executed' => $app->get('kernel.bootstrappers.executed'),
]);