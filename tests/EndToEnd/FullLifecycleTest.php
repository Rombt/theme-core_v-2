<?php

declare(strict_types=1);

namespace Tests\EndToEnd;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Rombt\ThemeCore\Composition\Assembler\RuntimeAssembler;
use Rombt\ThemeCore\Runtime\BuildRunner;
use Rombt\ThemeCore\Runtime\RuntimeKernel;
use Rombt\ThemeCore\Runtime\Pipeline\Pipeline;
use Rombt\ThemeCore\Runtime\Stages\BuildThemeStage;
use Rombt\ThemeCore\Runtime\Result\BuildResult;

final class FullLifecycleTest extends TestCase
{
    public function testFullApplicationLifecycle(): void
    {
        $app = new Application();

        $registry = new BootstrapRegistry();

        $registry->register(\Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateApplicationContextBuilderBootstrapper::class);
        $registry->register(\Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper::class);
        $registry->register(\Rombt\ThemeCore\Bootstrap\Bootstrappers\LoadConfigurationBootstrapper::class);
        $registry->register(\Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateDiagnosticsBootstrapper::class);
        $registry->register(\Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateLoggerBootstrapper::class);
        $registry->register(\Rombt\ThemeCore\Bootstrap\Bootstrappers\CompositionBootstrapper::class);
        $registry->register(\Rombt\ThemeCore\Bootstrap\Bootstrappers\FinalizeApplicationContextBootstrapper::class);

        $kernel = new Kernel(
            $app,
            $registry,
            new BootstrapperFactory(),
            new KernelContext(),
            dirname(__DIR__, 2),
        );

        $kernel->bootstrap();

        $definitions = $kernel->context()->getServiceDefinitions();

        $compositionRuntime = (new RuntimeAssembler())->assemble($definitions);

        $runtimeKernel = new RuntimeKernel(
            new BuildRunner(
                sessionFactory: new \Rombt\ThemeCore\Runtime\Session\BuildSessionFactory(),
                contextFactory: new \Rombt\ThemeCore\Runtime\Context\ExecutionContextFactory(),
                runtime: new \Rombt\ThemeCore\Runtime\ExecutionRuntime(
                    new \Rombt\ThemeCore\Runtime\Result\BuildResultFactory(),
                    new \Rombt\ThemeCore\Runtime\Pipeline\PipelineExecutor()
                ),
                compositionRuntime: $compositionRuntime,
                app: $app
            )
        );

        $pipeline = new Pipeline([
            new BuildThemeStage(),
        ]);

        $result = $runtimeKernel->execute($pipeline);

        self::assertInstanceOf(
            BuildResult::class,
            $result
        );

        self::assertTrue(
            $app->getContext()->has(ApplicationContextKeys::LOGGER)
        );

        self::assertTrue(
            $app->getContext()->has(ApplicationContextKeys::DIAGNOSTICS)
        );
    }
}
