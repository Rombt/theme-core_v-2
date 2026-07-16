<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\Theme\ThemeDefinition;

interface ThemeDefinitionProviderInterface
{
    public function provide(): ThemeDefinition;
}
