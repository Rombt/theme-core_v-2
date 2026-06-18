<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Startup;

use Rombt\ThemeCore\Composition\Contracts\BootstrapPipelineInterface;
use Rombt\ThemeCore\Composition\Contracts\BootstrapStepInterface;
use Rombt\ThemeCore\Composition\Contracts\StartupPhaseInterface;

final class StartupPhase implements StartupPhaseInterface
{
    /**
     * @param BootstrapStepInterface[] $steps
     */
    public function __construct(
        private readonly BootstrapPipelineInterface $pipeline,
        private readonly array $steps
    ) {
    }

    public function execute(): void
    {
        $this->pipeline->run($this->steps);
    }
}
