<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

interface PipelineInterface
{
    /**
     * @return iterable<StageInterface>
     */
    public function getStages(): iterable;
}
