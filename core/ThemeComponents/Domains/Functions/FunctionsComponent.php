<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Functions;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;

final readonly class FunctionsComponent implements ThemeComponentInterface
{
    public function __construct(
        private FunctionComponentCollection $functions,
    ) {
    }

    public function functions(): FunctionComponentCollection
    {
        return $this->functions;
    }
}
