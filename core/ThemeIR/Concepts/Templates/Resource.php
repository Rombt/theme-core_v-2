<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Templates;

final readonly class Resource
{
    public function __construct(
        private string $value,
    ) {
    }

    public function value(): string
    {
        return $this->value;
    }
}
