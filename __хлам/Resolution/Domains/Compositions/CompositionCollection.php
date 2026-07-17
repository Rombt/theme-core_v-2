<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Compositions;

final readonly class CompositionCollection
{
    /**
     * @param array<string, Composition> $compositions
     */
    public function __construct(
        private array $compositions,
    ) {
    }

    /**
     * @return array<string, Composition>
     */
    public function all(): array
    {
        return $this->compositions;
    }

    public function get(string $id): ?Composition
    {
        return $this->compositions[$id] ?? null;
    }
}
