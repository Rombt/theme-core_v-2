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
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemeDefinitionProviderInterface;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;

final class BuildRunner implements BuildRunnerInterface
{
    public function __construct(
        private readonly BuildSessionFactoryInterface $sessionFactory,
        private readonly ExecutionContextFactoryInterface $contextFactory,
        private readonly ExecutionRuntimeInterface $runtime,
        private readonly CompositionRuntimeInterface $compositionRuntime,
        private readonly ThemeDefinitionProviderInterface $themeProvider,
        private readonly Application $app,
    ) {
    }

    public function run(PipelineInterface $pipeline): BuildResult
    {
        $theme = $this->themeProvider->provide();

        echo '$theme = ';
        print_r($theme);
        echo PHP_EOL;

        $session = $this->sessionFactory->create($theme);
        $session->setResource(SessionKeys::THEME_DEFINITION, $theme);
        $context = $this->contextFactory->create($session, $this->compositionRuntime);

        return $this->runtime->run(
            $context,
            $pipeline,
            $this->app
        );
    }
}
