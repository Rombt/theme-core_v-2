<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Result\BuildResult;

interface ExecutionRuntimeInterface
{
    public function run(
        ExecutionContext $context,
        PipelineInterface $pipeline
    ): BuildResult;
}
