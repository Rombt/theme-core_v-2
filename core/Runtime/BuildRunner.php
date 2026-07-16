<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildRunnerInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionContextFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionRuntimeInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\SelectedPackageProviderInterface;

final class BuildRunner implements BuildRunnerInterface
{
    public function __construct(
        private readonly BuildSessionFactoryInterface $sessionFactory,
        private readonly ExecutionContextFactoryInterface $contextFactory,
        private readonly ExecutionRuntimeInterface $runtime,
        private readonly CompositionRuntimeInterface $compositionRuntime,
        private readonly SelectedPackageProviderInterface $packageProvider,
        private readonly Application $app,
    ) {
    }

    public function run(PipelineInterface $pipeline): BuildResult
    {
        $package = $this->packageProvider->provide();

        $session = $this->sessionFactory->create($package);


        echo '$session = ';
        print_r($session);
        echo PHP_EOL;

        $context = $this->contextFactory->create(
            $session,
            $this->compositionRuntime,
        );

        return $this->runtime->run(
            $context,
            $pipeline,
            $this->app,
        );
    }
}
