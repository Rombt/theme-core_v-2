<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelState;
use Rombt\ThemeCore\Bootstrap\KernelContext;

$app = new Application();

$bootstrapRegistry = new BootstrapRegistry();
$bootstrapRegistry->register(SetInternalEncodingBootstrapper::class);

$bootstrapperFactory = new BootstrapperFactory();

$context = new KernelContext($app);

$kernel = new Kernel(
    $app,
    $bootstrapRegistry,
    $bootstrapperFactory,
    $context,
);

$kernel->bootstrap();

print_r([
    'status' => $context->getStatus()?->value,
    'current' => $app->get(KernelState::BOOTSTRAP_CURRENT),
    'executed' => $app->get(KernelState::BOOTSTRAPPERS_EXECUTED),
]);