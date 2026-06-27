<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\ArtifactCollectionFactory;
use Rombt\ThemeCore\Artifacts\WordPressThemeArtifactGenerator;
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
use Rombt\ThemeCore\Composition\Assembler\RuntimeAssembler;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportRenderer;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\CompositeWriter;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\ConsoleWriter;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\FilesystemWriter;
use Rombt\ThemeCore\Runtime\BuildRunner;
use Rombt\ThemeCore\Runtime\Context\ExecutionContextFactory;
use Rombt\ThemeCore\Runtime\ExecutionRuntime;
use Rombt\ThemeCore\Runtime\Pipeline\Pipeline;
use Rombt\ThemeCore\Runtime\Pipeline\PipelineExecutor;
use Rombt\ThemeCore\Runtime\Result\BuildResultFactory;
use Rombt\ThemeCore\Runtime\RuntimeKernel;
use Rombt\ThemeCore\Runtime\Session\BuildSessionFactory;
use Rombt\ThemeCore\Runtime\Stages\GenerateThemeArtifactsStage;
use Rombt\ThemeCore\Runtime\Stages\WriteThemeArtifactsStage;
use Rombt\ThemeCore\Runtime\Stages\FinalizeBuildStage;
use Rombt\ThemeCore\Theme\ThemeComponentBuilderRegistry;
use Rombt\ThemeCore\Theme\ThemeDefinitionBuilder;
use Rombt\ThemeCore\Theme\ThemeMetadataFactory;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesComponentBuilder;
use Rombt\ThemeCore\ThemeConfiguration\PackageLoaderService;
use Rombt\ThemeCore\ThemeConfiguration\PackageValidator;
use Rombt\ThemeCore\ThemeConfiguration\RegistryPackageSelector;
use Rombt\ThemeCore\ThemeConfiguration\ThemeDefinitionProvider;
use Rombt\ThemeCore\ThemeConfiguration\PackageLoader;
use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistration;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistry;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesValidator;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Application Bootstrap
|--------------------------------------------------------------------------
*/

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
$definitions = $kernel->context()->getServiceDefinitions();
$compositionRuntime = (new RuntimeAssembler($app))->assemble($definitions);

/*
|--------------------------------------------------------------------------
| Runtime
|--------------------------------------------------------------------------
*/
/** @var \Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface $configuration */
$configuration = $app->getContext()->get(ApplicationContextKeys::CONFIGURATION);

$themeProvider = new ThemeDefinitionProvider(
    $configuration,
    new RegistryPackageSelector(
        $compositionRuntime->packageRegistry()
    ),
    new PackageLoaderService(new PackageLoader(new DomainRegistry(
        [
            //!! здесь добавлять домены которые может обрабатывать приложение
            'templates' => new DomainRegistration(
                id: new DomainId('templates'),
                domainClass: TemplatesConfiguration::class,
                validator: new TemplatesValidator(),
            ),
        ]
    ))),
    new PackageValidator(),
    new ThemeDefinitionBuilder(
        new ThemeMetadataFactory(),
        new ThemeComponentBuilderRegistry([
            //!! здесь добавлять новые компоненты
            new TemplatesComponentBuilder(),
        ])
    )
);

$runtimeKernel = new RuntimeKernel(
    new BuildRunner(
        new BuildSessionFactory(
            new ArtifactCollectionFactory()
        ),
        new ExecutionContextFactory(),
        new ExecutionRuntime(
            new BuildResultFactory(),
            new PipelineExecutor()
        ),
        $compositionRuntime,
        $themeProvider,
        $app
    )
);

$buildRoot = $configuration->get('paths.build');


$pipeline = new Pipeline([

    new GenerateThemeArtifactsStage(
        new WordPressThemeArtifactGenerator()
    ),

    new WriteThemeArtifactsStage(
        $configuration
    ),

    new FinalizeBuildStage(),
]);

$result = $runtimeKernel->execute($pipeline);


echo PHP_EOL;
echo 'Build Status: ';
echo $result->getStatus();
echo PHP_EOL;

if ($result->getError() !== null) {
    echo 'Build Error: ';
    echo $result->getError()->getMessage();
    echo PHP_EOL;
}

/*
|--------------------------------------------------------------------------
| Runtime Shutdown
|--------------------------------------------------------------------------
*/

/** @var \Rombt\ThemeCore\Contracts\Logging\LoggerInterface $logger */
$logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);

$logger->write(
    new DiagnosticEntry(
        level: DiagnosticLevel::INFO,
        message: 'Project execution completed successfully',
        context: new DiagnosticContext([
            'stage' => 'runtime_finish',
        ]),
        metadata: [
            'build_status' => $result->getStatus(),
        ],
        timestamp: new DateTimeImmutable(),
    )
);

/** @var \Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService $diagnostics */
$diagnostics = $app->getContext()->get(
    ApplicationContextKeys::DIAGNOSTICS
);

$diagnosticsFilePath = $configuration->get(
    'diagnostic.path'
);

if (!is_string($diagnosticsFilePath)) {
    throw new RuntimeException(
        'Configuration key "diagnostic.path" must be string.'
    );
}

$writer = new CompositeWriter([
    new ConsoleWriter(),
    new FilesystemWriter($diagnosticsFilePath),
]);

$reportRenderer = new DiagnosticReportRenderer();

$writer->write(
    $reportRenderer->render(
        $diagnostics->report()
    )
);

return $app;
