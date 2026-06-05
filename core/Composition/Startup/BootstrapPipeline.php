<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Startup;

use Rombt\ThemeCore\Composition\Contracts\BootstrapPipelineInterface;
use Rombt\ThemeCore\Composition\Contracts\BootstrapStepInterface;

final class BootstrapPipeline implements BootstrapPipelineInterface
{
    /**
     * @param BootstrapStepInterface[] $steps
     */
    public function run(array $steps): void
    {
        foreach ($steps as $step) {
            $step->execute();
        }
    }
}
