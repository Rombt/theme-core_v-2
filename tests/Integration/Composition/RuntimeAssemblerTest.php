<?php

declare(strict_types=1);

namespace Tests\Integration\Composition;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Composition\Assembler\RuntimeAssembler;
use Rombt\ThemeCore\Composition\Contracts\ServiceFactoryInterface;
use Rombt\ThemeCore\Composition\Contracts\LifecycleManagerInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Composition\Graph\DependencyGraphBuilder;
use Rombt\ThemeCore\Composition\Graph\TopologicalSorter;
use Rombt\ThemeCore\Composition\Registry\ServiceRegistry;
use Rombt\ThemeCore\Composition\Resolution\DependencyResolver;
use Rombt\ThemeCore\Composition\Resolution\ResolutionContext;
use Rombt\ThemeCore\Composition\Resolution\ServiceComposer;
use Rombt\ThemeCore\Composition\Contracts\ServiceComposerInterface;
use Rombt\ThemeCore\Composition\Runtime\CompositionRuntime;
use Tests\Support\Fakes\DummyService;
use Tests\Support\Fakes\DummyServiceFactory;
use Tests\Support\Fakes\DummyLifecycleManager;

final class RuntimeAssemblerTest extends TestCase
{
    public function testRuntimeIsAssembledSuccessfully(): void
    {
        $registry = new ServiceRegistry();

        $registry->register(
            new ServiceDefinition(
                identifier: DummyService::class,
                class: DummyService::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: []
            )
        );

        $graph = (new DependencyGraphBuilder())->build($registry);

        $composer = new ServiceComposer(
            registry: $registry,
            resolver: new DependencyResolver($graph),
            factory: new DummyServiceFactory(),
            lifecycleManager: new DummyLifecycleManager(),
            context: new ResolutionContext(),
        );

        $assembler = new RuntimeAssembler();

        $runtime = $assembler->assemble($registry->all());

        self::assertInstanceOf(
            CompositionRuntime::class,
            $runtime
        );

        self::assertInstanceOf(
            ServiceComposerInterface::class,
            $runtime->services()
        );

        self::assertInstanceOf(
            DummyService::class,
            $runtime->services()->get(DummyService::class)
        );
    }
}
