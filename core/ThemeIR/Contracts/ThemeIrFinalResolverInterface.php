<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

use Rombt\ThemeCore\ThemeIR\ThemeIR;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;

interface ThemeIrFinalResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
        ThemeIR $themeIr,
    ): ThemeConceptInterface;
}
