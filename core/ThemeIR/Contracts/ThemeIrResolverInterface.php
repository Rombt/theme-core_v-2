<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;

interface ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
    ): ThemeConceptInterface;
}
