<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Contracts;

use Rombt\ThemeCore\Theme\ThemeDefinition;
use Rombt\ThemeCore\ThemeConfiguration\ValidatedPackage;

interface ThemeDefinitionBuilderInterface
{
    public function build(ValidatedPackage $package,): ThemeDefinition;
}
