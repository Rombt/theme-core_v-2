<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ValueObjects\ResourceArchitecture;

final readonly class ResolvedResource
{
    /**
     * @param array<ResourceArchitecture, ResolvedResourceArchitecture> $architectures
     */
    public function __construct(
        private Resource $resource,
        private array $architectures,
    ) {
    }

    public function resource(): Resource
    {
        return $this->resource;
    }

    /**
     * @return array<ResourceArchitecture, ResolvedResourceArchitecture>
     */
    public function architectures(): array
    {
        return $this->architectures;
    }

    public function architecture(
        ResourceArchitecture $architecture,
    ): ?ResolvedResourceArchitecture {
        return $this->architectures[$architecture->value] ?? null;
    }
}
