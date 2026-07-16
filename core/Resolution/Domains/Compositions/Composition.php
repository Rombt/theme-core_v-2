<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Compositions;

final readonly class Composition
{
    /**
     * @param array<CompositionChild|string> $children
     */
    public function __construct(
        private string $id,
        private string $type,
        private array $children,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return array<CompositionChild|string>
     */
    public function children(): array
    {
        return $this->children;
    }
}
