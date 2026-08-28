<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Templates\ValueObjects;

final readonly class TemplateIdentity
{
    public function __construct(
        private string $value,
    ) {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
