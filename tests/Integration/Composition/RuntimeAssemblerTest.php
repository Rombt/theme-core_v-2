<?php

declare(strict_types=1);

namespace Tests\Integration\Composition;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;
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
use Rombt\ThemeCore\Composition\Contracts\ServiceComposerInterface;
use Rombt\ThemeCore\Composition\Runtime\CompositionRuntime;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistryProvider;

final class RuntimeAssemblerTest extends TestCase
{
    public function testRuntimeIsAssembledSuccessfully(): void
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
            dirname(__DIR__, 3),
        );

        $kernel->bootstrap();

        $runtime = (new RuntimeAssembler($app))->assemble(
            $kernel->context()->getServiceDefinitions()
        );

        self::assertInstanceOf(CompositionRuntime::class, $runtime);
        self::assertInstanceOf(ServiceComposerInterface::class, $runtime->services());
        self::assertInstanceOf(
            ThemePackageRegistryProvider::class,
            $runtime->services()->get(ThemePackageRegistryProvider::class)
        );
    }
}
