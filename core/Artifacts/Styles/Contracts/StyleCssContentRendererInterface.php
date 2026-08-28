<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Styles\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

interface StyleCssContentRendererInterface
{
    public function render(
        ThemeConfigurationPackage $package,
    ): string;
}
