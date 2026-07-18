<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

interface ThemeIrResolverInterface
{
    public function supports(ThemeComponent $component): bool;

    public function resolve(ThemeComponent $component): ThemeIrCollection;
}
