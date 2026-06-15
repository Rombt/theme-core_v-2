<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;

interface PipelineExecutorInterface
{
    public function execute(
        PipelineInterface $pipeline,
        ExecutionContext $context,
        Application $app
    ): bool;
}
