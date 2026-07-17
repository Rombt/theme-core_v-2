<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeDefinition;
use Rombt\ThemeCore\ThemeConfiguration\ValidatedPackage;

interface ThemeDefinitionBuilderInterface
{
    public function build(ValidatedPackage $package,): ThemeDefinition;
}
