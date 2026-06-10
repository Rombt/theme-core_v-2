<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Pipeline;

use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;

final class Pipeline implements PipelineInterface
{
    /**
     * @param iterable<StageInterface> $stages
     */
    public function __construct(
        private iterable $stages
    ) {
    }

    public function getStages(): iterable
    {
        return $this->stages;
    }
}
