<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

interface ThemeConceptInterface extends FunctionComponentsProviderInterface
{
    public function id(): string;
}
