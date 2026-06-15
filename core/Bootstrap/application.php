<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\LoadConfigurationBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateDiagnosticsBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateLoggerBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateApplicationContextBuilderBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\FinalizeApplicationContextBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CompositionBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

$app = new Application();

$bootstrapRegistry = new BootstrapRegistry();

$bootstrapRegistry->register(CreateApplicationContextBuilderBootstrapper::class); // этот должен быть самым первым!
$bootstrapRegistry->register(SetInternalEncodingBootstrapper::class);
$bootstrapRegistry->register(LoadConfigurationBootstrapper::class);
$bootstrapRegistry->register(CreateDiagnosticsBootstrapper::class);
$bootstrapRegistry->register(CreateLoggerBootstrapper::class);
$bootstrapRegistry->register(CompositionBootstrapper::class);



$bootstrapRegistry->register(FinalizeApplicationContextBootstrapper::class);  // этот должен быть последним!

$kernel = new Kernel(
    $app,
    $bootstrapRegistry,
    new BootstrapperFactory(),
    new KernelContext($app),
    dirname(__DIR__, 2),
);

$kernel->bootstrap();

$compositionRuntime = $app->getContext()->get(ApplicationContextKeys::COMPOSITION_RUNTIME);


echo '$compositionRuntime = ';
print_r($compositionRuntime);
echo PHP_EOL;

$ApplicationContext = $app->getContext();
echo '$ApplicationContext = ';
print_r($ApplicationContext);
echo PHP_EOL;



return $app;
