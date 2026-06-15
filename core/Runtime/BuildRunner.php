<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildRunnerInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionContextFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionRuntimeInterface;

final class BuildRunner implements BuildRunnerInterface
{
    public function __construct(
        private readonly BuildSessionFactoryInterface $sessionFactory,
        private readonly ExecutionContextFactoryInterface $contextFactory,
        private readonly ExecutionRuntimeInterface $runtime,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function run(
        CompositionRuntimeInterface $compositionRuntime,
        PipelineInterface $pipeline
    ): BuildResult {
        $session = $this->sessionFactory->create(
            $this->logger
        );

        $context = $this->contextFactory->create(
            $session,
            $compositionRuntime
        );

        return $this->runtime->run(
            $context,
            $pipeline
        );
    }
}
