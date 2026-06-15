<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use Rombt\ThemeCore\Runtime\Contracts\BuildRunnerInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\RuntimeKernelInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;

final class RuntimeKernel implements RuntimeKernelInterface
{
    public function __construct(
        private readonly BuildRunnerInterface $buildRunner,
    ) {
    }

    public function execute(
        PipelineInterface $pipeline
    ): BuildResult {
        return $this->buildRunner->run(
            $pipeline
        );
    }
}
