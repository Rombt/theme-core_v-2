<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;

interface ServiceDefinitionProviderInterface
{
    /**
     * @return ServiceDefinition[]
     */
    public function provide(): array;
}
