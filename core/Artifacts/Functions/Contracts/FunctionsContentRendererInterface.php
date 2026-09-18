<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Functions\Contracts;

use Rombt\ThemeCore\ThemeIR\Domains\Functions\FunctionsInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

interface FunctionsContentRendererInterface
{
    public function render(FunctionsInterface $functions): string;
}
