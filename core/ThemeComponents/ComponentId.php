<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents;

final readonly class ComponentId
{
    public function __construct(
        private string $value,
    ) {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(
        self $other,
    ): bool {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
