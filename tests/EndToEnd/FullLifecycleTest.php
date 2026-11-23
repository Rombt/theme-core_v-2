<?php

declare(strict_types=1);


namespace Tests\EndToEnd;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Artifacts\ArtifactCollectionFactory;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
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
use Rombt\ThemeCore\Runtime\BuildRunner;
use Rombt\ThemeCore\Runtime\Context\ExecutionContextFactory;
use Rombt\ThemeCore\Runtime\ExecutionRuntime;
use Rombt\ThemeCore\Runtime\Pipeline\Pipeline;
use Rombt\ThemeCore\Runtime\Pipeline\PipelineExecutor;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Result\BuildResultFactory;
use Rombt\ThemeCore\Runtime\RuntimeKernel;
use Rombt\ThemeCore\Runtime\Session\BuildSessionFactory;
use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistration;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistry;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Entities\EntitiesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Entities\EntitiesValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Functions\FunctionsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Functions\FunctionsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations\IntegrationsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations\IntegrationsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Queries\QueriesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Queries\QueriesValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Workflows\WorkflowsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Workflows\WorkflowsValidator;
use Rombt\ThemeCore\ThemeConfiguration\PackageLoader;
use Rombt\ThemeCore\ThemeConfiguration\RegistryPackageSelector;
use Rombt\ThemeCore\ThemeConfiguration\SelectedPackageProvider;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetProjectRootBootstrapper;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportRenderer;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\CompositeWriter;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\ConsoleWriter;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\FilesystemWriter;
use Rombt\ThemeCore\Runtime\Stages\WriteThemeArtifactsStage;
use Rombt\ThemeCore\Runtime\Stages\FinalizeBuildStage;
use Rombt\ThemeCore\Artifacts\ArtifactGeneratorRegistryFactory;
use Rombt\ThemeCore\Artifacts\ThemeArtifactGenerator;
use Rombt\ThemeCore\Runtime\Stages\GenerateIrArtifactsStage;
use Rombt\ThemeCore\Artifacts\Generators\CompositionArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Generators\FunctionsPhpArtifactGenerator;
use Rombt\ThemeCore\Runtime\Stages\BuildThemeIRStage;
use Rombt\ThemeCore\Runtime\Stages\BuildThemeComponentsStage;
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
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionsComponentBuilder;
use Rombt\ThemeCore\ThemeIR\Domains\Functions\FunctionsThemeIrResolver;
use Rombt\ThemeCore\ThemeIR\Domains\Functions\FunctionRequirementCollector;
use Rombt\ThemeCore\Artifacts\Functions\BlockFunctionsArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Functions\BlockFunctionsContentRenderer;
use Rombt\ThemeCore\Artifacts\Functions\ClassicFunctionsArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Functions\ClassicFunctionsContentRenderer;
use Rombt\ThemeCore\Artifacts\Functions\FunctionsPathResolver;
use Rombt\ThemeCore\Artifacts\Templates\PhpParserContentNormalizer;
use Rombt\ThemeCore\Artifacts\Assets\AssetArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Assets\AssetContentRenderer;
use Rombt\ThemeCore\Artifacts\Assets\AssetPathResolver;
use Rombt\ThemeCore\Artifacts\Assets\AssetResourceReader;
use Rombt\ThemeCore\Runtime\Stages\FormatThemeStage;
use Rombt\ThemeCore\Runtime\Process\ExternalProcessRunner;
use Rombt\ThemeCore\Runtime\Formatters\HtmlBeautifyThemeFormatter;
use Rombt\ThemeCore\Runtime\Formatters\PhpcbfThemeFormatter;

final class FullLifecycleTest extends TestCase
{
    public function testFullApplicationLifecycle(): void
    {
        $app = new Application();
        $registry = new BootstrapRegistry();

        $registry->register(CreateApplicationContextBuilderBootstrapper::class);
        $registry->register(SetInternalEncodingBootstrapper::class);
        $registry->register(LoadConfigurationBootstrapper::class);
        $registry->register(CreateDiagnosticsBootstrapper::class);
        $registry->register(CreateLoggerBootstrapper::class);
        $registry->register(CompositionBootstrapper::class);
        $registry->register(FinalizeApplicationContextBootstrapper::class);

        $kernel = new Kernel(
            $app,
            $registry,
            new BootstrapperFactory(),
            new KernelContext(),
            dirname(__DIR__, 2),
        );

        $kernel->bootstrap();

        $definitions = $kernel->context()->getServiceDefinitions();
        $compositionRuntime = (new RuntimeAssembler($app))->assemble($definitions);
        $configuration = $app->getContext()->get(ApplicationContextKeys::CONFIGURATION);
        $packageProvider = new SelectedPackageProvider(
            $configuration,
            new RegistryPackageSelector($compositionRuntime->packageRegistry()),
            new PackageLoader(
                new DomainRegistry([
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
        );
        $architecture = $packageProvider->architecture()->value;

        $runtimeKernel = new RuntimeKernel(
            new BuildRunner(
                sessionFactory: new BuildSessionFactory(new ArtifactCollectionFactory()),
                contextFactory: new ExecutionContextFactory(),
                runtime: new ExecutionRuntime(
                    new BuildResultFactory(),
                    new PipelineExecutor(),
                ),
                compositionRuntime: $compositionRuntime,
                packageProvider: $packageProvider,
                app: $app,
            ),
        );

        if ($architecture === 'classic') {
            $classicTemplatePathResolver = new ClassicTemplatePathResolver();
            $classicNodeMaterializer = new ClassicTemplateNodeMaterializer(
                $classicTemplatePathResolver,
                $app,
            );

            $architectureGenerators = [
                new ClassicTemplateArtifactGenerator(
                    new ClassicTemplateTreeRenderer(
                        new ClassicTemplateTreeMaterializer($classicNodeMaterializer, $app),
                        new PhpParserContentNormalizer($configuration),
                    ),
                    $classicNodeMaterializer,
                    $classicTemplatePathResolver,
                    $app,
                ),
                new AssetArtifactGenerator(
                    new AssetResourceReader($app, 'classic'),
                    new AssetContentRenderer(),
                    new AssetPathResolver(),
                    'classic',
                ),
                new ClassicFunctionsArtifactGenerator(
                    new ClassicFunctionsContentRenderer($app),
                    new FunctionsPathResolver(),
                    $app,
                ),
            ];
        } else {
            $blockNodeMaterializer = new BlockTemplateNodeMaterializer($app);

            $architectureGenerators = [
                new BlockTemplateArtifactGenerator(
                    new BlockTemplateTreeRenderer(
                        new BlockTemplateTreeMaterializer($blockNodeMaterializer),
                    ),
                    $blockNodeMaterializer,
                    new BlockTemplatePathResolver(),
                ),
                new AssetArtifactGenerator(
                    new AssetResourceReader($app, 'block'),
                    new AssetContentRenderer(),
                    new AssetPathResolver(),
                    'block',
                ),
                new BlockFunctionsArtifactGenerator(
                    new BlockFunctionsContentRenderer($app),
                    new FunctionsPathResolver(),
                ),
            ];
        }

        $pipeline = new Pipeline(
            array(

                new BuildThemeComponentsStage(
                    new ThemeComponentBuilder(
                        new ThemeComponentBuilderRegistry(
                            array(
                                new NodesComponentBuilder(),
                                new TemplatesComponentBuilder(),
                                new CompositionsComponentBuilder(
                                    new CompositionCollectionBuilder(),
                                ),
                                new AssetsComponentBuilder(),
                                new DesignSystemsComponentBuilder(),
                                new IntegrationsComponentBuilder(),
                                new FunctionsComponentBuilder(),
                            )
                        ),
                    ),
                ),

                new BuildThemeIRStage(
                    new ThemeIRBuilder(
                        new ThemeIRResolverRegistry(
                            resolvers: array(
                                // Compositions используются TemplatesThemeIRResolver
                                // для построения Templates IR concept.
                                new TemplatesThemeIRResolver(),

                                new DesignSystemsThemeIRResolver(),
                                new AssetsThemeIRResolver(
                                    $app->getContext()->get(ApplicationContextKeys::DIAGNOSTICS),
                                ),
                                new IntegrationsThemeIRResolver(),
                            ),
                            finalResolvers: array(
                                new FunctionsThemeIrResolver(
                                    new FunctionRequirementCollector(),
                                ),
                            ),
                        ),
                    ),
                ),

                new GenerateIrArtifactsStage(
                    new ThemeArtifactGenerator(
                        ( new ArtifactGeneratorRegistryFactory() )->create(
                            array_merge(
                                [
                                    new StyleCssArtifactGenerator(
                                        new StyleCssContentRenderer(),
                                        new StyleCssPathResolver(),
                                        $app,
                                    ),
                                ],
                                $architectureGenerators,
                            ),
                        ),
                        $app
                    ),
                ),

                new WriteThemeArtifactsStage(
                    $configuration
                ),

                // отключил на время разработки доменов что бы не мешало
                // new FormatThemeStage(
                //     array(
                //         new HtmlBeautifyThemeFormatter(
                //             new ExternalProcessRunner(),
                //             $app,
                //         ),
                //         new PhpcbfThemeFormatter(
                //             new ExternalProcessRunner(),
                //             $app,
                //         ),

                //     ),
                // ),

                new FinalizeBuildStage(),
            )
        );

        $result = $runtimeKernel->execute($pipeline);

        self::assertInstanceOf(BuildResult::class, $result);
        self::assertTrue($app->getContext()->has(ApplicationContextKeys::LOGGER));
        self::assertTrue($app->getContext()->has(ApplicationContextKeys::DIAGNOSTICS));
    }
}
