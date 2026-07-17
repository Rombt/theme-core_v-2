<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

interface ThemeComponentCollectionBuilderInterface
{
    public function build(
        ThemeConfigurationPackage $package,
    ): ThemeComponentCollection;
}
