<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Composition\Assembler\RuntimeAssembler;
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
use Rombt\ThemeCore\Runtime\Stages\BuildThemeStage;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportRenderer;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\CompositeWriter;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\ConsoleWriter;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\FilesystemWriter;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
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
    new KernelContext(),
    dirname(__DIR__, 2),
);

$kernel->bootstrap();


// echo '$app = ';
// print_r($app);
// echo PHP_EOL;

// die();

$definitions = $kernel->context()->getServiceDefinitions();

$compositionRuntime = (new RuntimeAssembler())->assemble($definitions);



/*
|--------------------------------------------------------------------------
| Runtime Entry Point
|--------------------------------------------------------------------------
*/

/** здесь начинается слой бизнес логики.
 *   сюда должны приходить отдельно друг от друга
 *       ApplicationContext
 *       compositionRuntime
 *   при этом
 *       ApplicationContext пробрасывается
 *           внутрь всех слоёв приложения как независимый и не изменяемый объект
 *       compositionRuntime должен стать
 *           неизменяемой частью ExecutionContext т.к. содержит всё необходимое для бизнес процессов
*/


$runtimeKernel = new RuntimeKernel(
    new BuildRunner(
        new BuildSessionFactory(),
        new ExecutionContextFactory(),
        new ExecutionRuntime(new BuildResultFactory(), new PipelineExecutor()),
        $compositionRuntime,
        $app
    )
);

$pipeline = new Pipeline([
    // стадии будут добавляться здесь
    //  new TestStage(),
     new BuildThemeStage(),

]);

$result = $runtimeKernel->execute($pipeline);


/** @var \Rombt\ThemeCore\Contracts\Logging\LoggerInterface $logger */
$logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);

$logger->write(
    new DiagnosticEntry(
        level: DiagnosticLevel::INFO,
        message: 'Project execution completed successfully',
        context: new DiagnosticContext([
            'stage' => 'runtime_finish',
        ]),
        metadata: [],
        timestamp: new \DateTimeImmutable(),
    )
);


$diagnostics = $app->getContext()->get(ApplicationContextKeys::DIAGNOSTICS);
$diagnostics_file_path = $app->getContext()->get(ApplicationContextKeys::CONFIGURATION)->get('diagnostic.path');

$renderer = new DiagnosticReportRenderer();


$writer = new CompositeWriter([
    new ConsoleWriter(),
    new FilesystemWriter($diagnostics_file_path)
]);

$reportFormatter = new DiagnosticReportRenderer();
$writer->write($reportFormatter->render($diagnostics->report()));



return $app;
