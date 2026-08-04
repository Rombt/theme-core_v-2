<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\ThemeIr;

interface ThemeIrBuilderInterface
{
    public function build(ThemeComponentCollection $components): ThemeIr;
}
