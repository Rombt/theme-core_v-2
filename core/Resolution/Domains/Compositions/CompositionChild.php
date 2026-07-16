<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Compositions;

final readonly class CompositionChild
{
    /**
     * @param array<CompositionChild|string> $children
     */
    public function __construct(
        private string $id,
        private array $children = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return array<CompositionChild|string>
     */
    public function children(): array
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return $this->children !== [];
    }
}
