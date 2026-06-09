<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Session\BuildSession;

interface PipelineExecutorInterface
{
    public function execute(
        PipelineInterface $pipeline,
        BuildSession $session
    ): void;
}
