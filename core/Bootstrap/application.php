<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CompositionBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateApplicationContextBuilderBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateDiagnosticsBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateLoggerBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\FinalizeApplicationContextBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\LoadConfigurationBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Rombt\ThemeCore\Runtime\RuntimeKernel;
use Rombt\ThemeCore\Runtime\BuildRunner;
use Rombt\ThemeCore\Runtime\ExecutionRuntime;
use Rombt\ThemeCore\Runtime\Pipeline\Pipeline;
use Rombt\ThemeCore\Runtime\Pipeline\PipelineExecutor;
use Rombt\ThemeCore\Runtime\Result\BuildResultFactory;
use Rombt\ThemeCore\Runtime\Session\BuildSessionFactory;
use Rombt\ThemeCore\Runtime\Context\ExecutionContextFactory;
use Rombt\ThemeCore\Runtime\Stages\TestStage;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

$app = new Application();

$bootstrapRegistry = new BootstrapRegistry();

$bootstrapRegistry->register(CreateApplicationContextBuilderBootstrapper::class);
$bootstrapRegistry->register(SetInternalEncodingBootstrapper::class);
$bootstrapRegistry->register(LoadConfigurationBootstrapper::class);
$bootstrapRegistry->register(CreateDiagnosticsBootstrapper::class);
$bootstrapRegistry->register(CreateLoggerBootstrapper::class);
$bootstrapRegistry->register(CompositionBootstrapper::class);
$bootstrapRegistry->register(FinalizeApplicationContextBootstrapper::class);

$kernel = new Kernel(
    $app,
    $bootstrapRegistry,
    new BootstrapperFactory(),
    new KernelContext($app),
    dirname(__DIR__, 2),
);

$kernel->bootstrap();

$compositionRuntime = $app->getContext()->get(ApplicationContextKeys::COMPOSITION_RUNTIME);

/*
|--------------------------------------------------------------------------
| Runtime Entry Point
|--------------------------------------------------------------------------
*/

$runtimeKernel = new RuntimeKernel(
    new BuildRunner(
        new BuildSessionFactory(),
        new ExecutionContextFactory(),
        new ExecutionRuntime(new BuildResultFactory(), new PipelineExecutor()),
        $compositionRuntime
    )
);

echo '$runtimeKernel = ';
print_r($runtimeKernel);
echo PHP_EOL;



$pipeline = new Pipeline([
    // стадии будут добавляться здесь
     new TestStage(),
]);

$result = $runtimeKernel->execute($pipeline);

return $app;
