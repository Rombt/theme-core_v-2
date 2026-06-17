<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Assembler;

use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;
use Rombt\ThemeCore\Composition\Contracts\RuntimeAssemblerInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Factory\ServiceFactory;
use Rombt\ThemeCore\Composition\Graph\DependencyGraphBuilder;
use Rombt\ThemeCore\Composition\Lifecycle\LifecycleManager;
use Rombt\ThemeCore\Composition\Registry\ServiceRegistry;
use Rombt\ThemeCore\Composition\Resolution\DependencyResolver;
use Rombt\ThemeCore\Composition\Resolution\ResolutionContext;
use Rombt\ThemeCore\Composition\Resolution\ServiceComposer;
use Rombt\ThemeCore\Composition\Runtime\CompositionRuntime;
use Rombt\ThemeCore\Composition\Startup\StartupPhase;
use Rombt\ThemeCore\Composition\Startup\BootstrapPipeline;
use Rombt\ThemeCore\Composition\Startup\EagerBootstrapStep;

final class RuntimeAssembler implements RuntimeAssemblerInterface
{
    public function __construct()
    {
        // intentionally empty
    }

    /**
     * @param ServiceDefinition[] $definitions
     */
    public function assemble(array $definitions): CompositionRuntimeInterface
    {

        $registry = new ServiceRegistry();

        foreach ($definitions as $definition) {
            $registry->register($definition);
        }

        $graph = (new DependencyGraphBuilder())->build($registry);

        $composer = new ServiceComposer($registry, new DependencyResolver($graph), new ServiceFactory(), new LifecycleManager(), new ResolutionContext());


        $startup = new StartupPhase(
            new BootstrapPipeline(),
            [
                new EagerBootstrapStep($registry, $composer),
            ]
        );

        $startup->execute();
        return new CompositionRuntime($composer);
    }
}
