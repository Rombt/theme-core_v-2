<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;

interface RuntimeAssemblerInterface
{
    /**
     * @param ServiceDefinition[] $definitions
     */
    public function assemble(
        array $definitions
    ): CompositionRuntimeInterface;
}
