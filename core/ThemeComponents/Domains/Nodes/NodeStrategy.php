<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

final readonly class NodeStrategy
{
    public function __construct(
        private string $value,
    ) {
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $strategy): bool
    {
        return $this->value === $strategy->value;
    }
}
