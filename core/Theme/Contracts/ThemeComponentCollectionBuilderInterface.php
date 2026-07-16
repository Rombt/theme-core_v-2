<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Contracts;

use Rombt\ThemeCore\Theme\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

interface ThemeComponentCollectionBuilderInterface
{
    public function build(
        ThemeConfigurationPackage $package,
    ): ThemeComponentCollection;
}
