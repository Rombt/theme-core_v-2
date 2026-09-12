<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\ArtifactCollectionFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CompositionBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateApplicationContextBuilderBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateDiagnosticsBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateLoggerBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\FinalizeApplicationContextBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\LoadConfigurationBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetProjectRootBootstrapper;
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
use Rombt\ThemeCore\Runtime\Stages\WriteThemeArtifactsStage;
use Rombt\ThemeCore\Runtime\Stages\FinalizeBuildStage;
use Rombt\ThemeCore\ThemeConfiguration\RegistryPackageSelector;
use Rombt\ThemeCore\ThemeConfiguration\PackageLoader;
use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistration;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistry;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Entities\EntitiesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Entities\EntitiesValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Queries\QueriesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Queries\QueriesValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Workflows\WorkflowsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Workflows\WorkflowsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations\IntegrationsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations\IntegrationsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesValidator;
use Rombt\ThemeCore\Artifacts\ArtifactGeneratorRegistryFactory;
use Rombt\ThemeCore\Artifacts\ThemeArtifactGenerator;
use Rombt\ThemeCore\Runtime\Stages\GenerateIrArtifactsStage;
use Rombt\ThemeCore\Artifacts\Generators\CompositionArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Generators\FunctionsPhpArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Renderers\WordPressFunctionsRenderer;
use Rombt\ThemeCore\WordPress\Assets\AssetRegistrationBuilder;
use Rombt\ThemeCore\Runtime\Stages\BuildThemeIRStage;
use Rombt\ThemeCore\Runtime\Stages\BuildThemeComponentsStage;
use Rombt\ThemeCore\ThemeConfiguration\SelectedPackageProvider;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentBuilder;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentBuilderRegistry;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponentBuilder;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponentBuilder;
use Rombt\ThemeCore\ThemeComponents\Domains\Templates\TemplatesComponentBuilder;
use Rombt\ThemeCore\ThemeComponents\Domains\DesignSystems\DesignSystemsComponentBuilder;
use Rombt\ThemeCore\ThemeComponents\Domains\Integrations\IntegrationsComponentBuilder;
use Rombt\ThemeCore\ThemeIR\ThemeIRBuilder;
use Rombt\ThemeCore\ThemeIR\ThemeIRResolverRegistry;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\TemplatesThemeIRResolver;
use Rombt\ThemeCore\ThemeIR\Domains\DesignSystems\DesignSystemsThemeIRResolver;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\AssetsThemeIRResolver;
use Rombt\ThemeCore\ThemeIR\Domains\Integrations\IntegrationsThemeIRResolver;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodesComponentBuilder;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ConventionResourceResolver;
use Rombt\ThemeCore\Artifacts\Templates\ClassicTemplateArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Templates\BlockTemplateArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Templates\ClassicTemplateTreeRenderer;
use Rombt\ThemeCore\Artifacts\Templates\BlockTemplateTreeRenderer;
use Rombt\ThemeCore\Artifacts\Templates\FileTemplateResourceContentReader;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionCollectionBuilder;
use Rombt\ThemeCore\Artifacts\Templates\BlockTemplateNodeMaterializer;
use Rombt\ThemeCore\Artifacts\Templates\BlockTemplateTreeMaterializer;
use Rombt\ThemeCore\Artifacts\Templates\ClassicTemplateNodeMaterializer;
use Rombt\ThemeCore\Artifacts\Templates\ClassicTemplateTreeMaterializer;
use Rombt\ThemeCore\Artifacts\Templates\ClassicTemplatePathResolver;
use Rombt\ThemeCore\Artifacts\Templates\BlockTemplatePathResolver;
use Rombt\ThemeCore\Artifacts\Styles\StyleCssArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Styles\StyleCssContentRenderer;
use Rombt\ThemeCore\Artifacts\Styles\StyleCssPathResolver;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Functions\FunctionsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Functions\FunctionsValidator;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionsComponentBuilder;
use Rombt\ThemeCore\ThemeIR\Domains\Functions\FunctionsThemeIrResolver;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionRequirementCollector;
use Rombt\ThemeCore\Artifacts\Functions\BlockFunctionsArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Functions\BlockFunctionsContentRenderer;
use Rombt\ThemeCore\Artifacts\Functions\ClassicFunctionsArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Functions\ClassicFunctionsContentRenderer;
use Rombt\ThemeCore\Artifacts\Functions\FunctionsPathResolver;
use Rombt\ThemeCore\Artifacts\Templates\PhpParserContentNormalizer;
use Rombt\ThemeCore\Runtime\Stages\FormatThemeStage;
use Rombt\ThemeCore\Runtime\Formatters\PrettierThemeFormatter;
use Rombt\ThemeCore\Runtime\Process\ExternalProcessRunner;

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
$bootstrapRegistry->register(SetProjectRootBootstrapper::class);

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

/** @var \Rombt\ThemeCore\Contracts\Logging\LoggerInterface $logger */
$logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);


$runtimeKernel = new RuntimeKernel(
    new BuildRunner(
        new BuildSessionFactory(
            new ArtifactCollectionFactory(), //todo при создании артефактов не используется удалить
        ),
        new ExecutionContextFactory(),
        new ExecutionRuntime(
            new BuildResultFactory(),
            new PipelineExecutor(),
        ),
        $compositionRuntime,
        new SelectedPackageProvider(
            $configuration,
            new RegistryPackageSelector(
                $compositionRuntime->packageRegistry(),
            ),
            new PackageLoader(
                new DomainRegistry([

                    //!! здесь добавлять домены которые может обрабатывать приложение

                    'templates' => new DomainRegistration(
                        id: new DomainId('templates'),
                        domainClass: TemplatesConfiguration::class,
                        validator: new TemplatesValidator(),
                    ),

                    'entities' => new DomainRegistration(
                        id: new DomainId('entities'),
                        domainClass: EntitiesConfiguration::class,
                        validator: new EntitiesValidator(),
                    ),

                    'compositions' => new DomainRegistration(
                        id: new DomainId('compositions'),
                        domainClass: CompositionsConfiguration::class,
                        validator: new CompositionsValidator(),
                    ),

                    'queries' => new DomainRegistration(
                        id: new DomainId('queries'),
                        domainClass: QueriesConfiguration::class,
                        validator: new QueriesValidator(),
                    ),

                    'workflows' => new DomainRegistration(
                        id: new DomainId('workflows'),
                        domainClass: WorkflowsConfiguration::class,
                        validator: new WorkflowsValidator(),
                    ),

                    'design-systems' => new DomainRegistration(
                        id: new DomainId('design-systems'),
                        domainClass: DesignSystemsConfiguration::class,
                        validator: new DesignSystemsValidator(),
                    ),

                    'assets' => new DomainRegistration(
                        id: new DomainId('assets'),
                        domainClass: AssetsConfiguration::class,
                        validator: new AssetsValidator(),
                    ),

                    'integrations' => new DomainRegistration(
                        id: new DomainId('integrations'),
                        domainClass: IntegrationsConfiguration::class,
                        validator: new IntegrationsValidator(),
                    ),

                'nodes' => new DomainRegistration(
                    id: new DomainId('nodes'),
                    domainClass: NodesConfiguration::class,
                    validator: new NodesValidator(),
                ),

                'functions' => new DomainRegistration(
                    id: new DomainId('functions'),
                    domainClass: FunctionsConfiguration::class,
                    validator: new FunctionsValidator(),
                ),

                ]),
            ),
        ),
        $app,
    ),
);

$buildRoot = $configuration->get('paths.build');
$resourcePackage = $configuration->get('theme.resource_package');



$classicTemplatePathResolver = new ClassicTemplatePathResolver();
$classicNodeMaterializer = new ClassicTemplateNodeMaterializer(
    $classicTemplatePathResolver,
    $app
);

$blockNodeMaterializer = new BlockTemplateNodeMaterializer($app);

$pipeline = new Pipeline([

    new BuildThemeComponentsStage(
        new ThemeComponentBuilder(
            new ThemeComponentBuilderRegistry([
                new NodesComponentBuilder(),
                new TemplatesComponentBuilder(),
                new CompositionsComponentBuilder(
                    new CompositionCollectionBuilder(),
                ),
                new AssetsComponentBuilder(),
                new DesignSystemsComponentBuilder(),
                new IntegrationsComponentBuilder(),
                new FunctionsComponentBuilder(),
            ]),
        ),
    ),

    new BuildThemeIRStage(
        new ThemeIRBuilder(
            new ThemeIRResolverRegistry(
                resolvers: [
                    // Compositions используются TemplatesThemeIRResolver
                    // для построения Templates IR concept.
                    new TemplatesThemeIRResolver(),

                    new DesignSystemsThemeIRResolver(),
                    new AssetsThemeIRResolver(),
                    new IntegrationsThemeIRResolver(),
                ],
                finalResolvers: [
                    new FunctionsThemeIrResolver(
                        new FunctionRequirementCollector(),
                    ),
                ],
            ),
        ),
    ),
    new GenerateIrArtifactsStage(
        new ThemeArtifactGenerator(
            (new ArtifactGeneratorRegistryFactory())->create(
                [
                    new ClassicTemplateArtifactGenerator(
                        new ClassicTemplateTreeRenderer(
                            new ClassicTemplateTreeMaterializer($classicNodeMaterializer, $app),
                            new PhpParserContentNormalizer($configuration),
                        ),
                        $classicNodeMaterializer,
                        $classicTemplatePathResolver,
                        $app,
                    ),

                    new BlockTemplateArtifactGenerator(
                        new BlockTemplateTreeRenderer(
                            new BlockTemplateTreeMaterializer(
                                $blockNodeMaterializer,
                            ),
                        ),
                        $blockNodeMaterializer,
                        new BlockTemplatePathResolver(),
                    ),

                    new StyleCssArtifactGenerator(
                        new StyleCssContentRenderer(),
                        new StyleCssPathResolver(),
                        $app
                    ),

                    new ClassicFunctionsArtifactGenerator(
                        new ClassicFunctionsContentRenderer(
                            $app,
                        ),
                        new FunctionsPathResolver(),
                        $app,
                    ),

                    new BlockFunctionsArtifactGenerator(
                        new BlockFunctionsContentRenderer(
                            $app,
                        ),
                        new FunctionsPathResolver(),
                    ),


                ],
            ),
            $app
        ),
    ),

    new WriteThemeArtifactsStage(
        $configuration
    ),

    new FormatThemeStage(
        new PrettierThemeFormatter(
            new ExternalProcessRunner(),
            $app,
        )
    ),

    new FinalizeBuildStage(),
    ]);


$result = $runtimeKernel->execute($pipeline);


    echo PHP_EOL;
    echo 'Build Status: ';
    echo $result->getStatus();
    echo PHP_EOL;

if ($result->getError() !== null) {
    $error = $result->getError();

    echo 'Build Error: ';
    echo $error->getMessage();
    echo PHP_EOL;

    echo 'File: ';
    echo $error->getFile();
    echo PHP_EOL;

    echo 'Line: ';
    echo $error->getLine();
    echo PHP_EOL;
}

/*
|--------------------------------------------------------------------------
| Runtime Shutdown
|--------------------------------------------------------------------------
*/


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
