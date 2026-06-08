<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\LoadConfigurationBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CompositionBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

$app = new Application();

$bootstrapRegistry = new BootstrapRegistry();

$bootstrapRegistry->register(SetInternalEncodingBootstrapper::class);
$bootstrapRegistry->register(LoadConfigurationBootstrapper::class);
$bootstrapRegistry->register(CompositionBootstrapper::class);

$kernel = new Kernel(
    $app,
    $bootstrapRegistry,
    new BootstrapperFactory(),
    new KernelContext($app),
    dirname(__DIR__, 2),
);

$kernel->bootstrap();

return $app;
