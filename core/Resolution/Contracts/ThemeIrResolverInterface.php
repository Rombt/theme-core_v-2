<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeComponents\ThemeIr;

interface ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
        ThemeIr $ir,
    ): ThemeIr;
}
