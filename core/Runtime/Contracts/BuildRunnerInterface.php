<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Result\BuildResult;

interface BuildRunnerInterface
{
    public function run(
        PipelineInterface $pipeline
    ): BuildResult;
}
