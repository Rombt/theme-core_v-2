<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

use Rombt\ThemeCore\ThemeIR\FunctionDefinition;

interface FunctionComponentInterface
{
    public function function(): ?FunctionDefinition;
}
