<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface BootstrapPipelineInterface
{
    /**
     * @param BootstrapStepInterface[] $steps
     */
    public function run(array $steps): void;
}
