<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrBuilderInterface;

final readonly class ThemeIrBuilder implements ThemeIrBuilderInterface
{
    public function build(
        ThemeComponentCollection $components,
    ): ThemeIR {
        return new ThemeIR();
    }
}
