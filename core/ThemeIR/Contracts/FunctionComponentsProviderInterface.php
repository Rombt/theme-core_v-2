<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

interface FunctionComponentsProviderInterface
{
    /**
     * @return list<FunctionComponentInterface>
     */
    public function functionComponents(): array;
}
