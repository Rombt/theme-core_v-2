<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelState;

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

$status = $app->get(
    KernelState::BOOTSTRAP_STATUS
);

print_r([
    'status' => $status?->value,
    'current' => $app->get(KernelState::BOOTSTRAP_CURRENT),
    'executed' => $app->get(KernelState::BOOTSTRAPPERS_EXECUTED),
]);