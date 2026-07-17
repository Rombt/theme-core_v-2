<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;

final readonly class CompositionsComponent implements ThemeComponentInterface
{
    public function __construct(
        private CompositionsConfiguration $compositions,
    ) {
    }

    public function compositions(): CompositionsConfiguration
    {
        return $this->compositions;
    }
}
