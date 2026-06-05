<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface RuntimeAssemblerInterface
{
    /**
     * @param ServiceDefinitionInterface[] $definitions
     */
    public function assemble(
        array $definitions
    ): CompositionRuntimeInterface;
}
