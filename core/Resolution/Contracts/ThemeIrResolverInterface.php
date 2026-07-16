<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Contracts;

use Rombt\ThemeCore\Theme\ThemeComponentCollection;
use Rombt\ThemeCore\Theme\ThemeIr;

interface ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
        ThemeIr $ir,
    ): ThemeIr;
}
