<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

final readonly class CompositionType
{
    public function __construct(
        private string $name,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }
}
