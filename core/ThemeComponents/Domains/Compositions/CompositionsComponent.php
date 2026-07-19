<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;

final readonly class CompositionsComponent implements ThemeComponentInterface
{
    public function __construct(
        private CompositionCollection $compositions,
    ) {
    }

    public function compositions(): CompositionCollection
    {
        return $this->compositions;
    }
}
