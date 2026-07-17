<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

interface ThemeIrBuilderInterface
{
    public function build(ThemeComponentCollection $components): ThemeIR;
}
