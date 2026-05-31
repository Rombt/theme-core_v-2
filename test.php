<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\LoadConfigurationBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelState;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Rombt\ThemeCore\Configuration\ConfigurationState;

$app = new Application();

$bootstrapRegistry = new BootstrapRegistry();
$bootstrapRegistry->register(SetInternalEncodingBootstrapper::class);
$bootstrapRegistry->register( LoadConfigurationBootstrapper::class );

$bootstrapperFactory = new BootstrapperFactory();

$context = new KernelContext($app);
$projectRoot = dirname(__DIR__);

$kernel = new Kernel(
    $app,
    $bootstrapRegistry,
    $bootstrapperFactory,
    $context,
    $projectRoot,
);

$kernel->bootstrap();

print_r([
    'status' => $context->getStatus()?->value,
    'current' => $app->get(KernelState::BOOTSTRAP_CURRENT),
    'executed' => $app->get(KernelState::BOOTSTRAPPERS_EXECUTED),

    'configuration' => $app->get(ConfigurationState::CONFIGURATION),
]);