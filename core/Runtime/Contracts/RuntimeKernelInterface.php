<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Result\BuildResult;

interface RuntimeKernelInterface
{
    public function execute(
        PipelineInterface $pipeline
    ): BuildResult;
}
