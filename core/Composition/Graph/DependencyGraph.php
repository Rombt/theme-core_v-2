<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Graph;

final class DependencyGraph
{
    /**
     * @param array<string, DependencyNode> $nodes
     */
    public function __construct(
        private array $nodes
    ) {
    }

    public function has(string $identifier): bool
    {
        return isset($this->nodes[$identifier]);
    }

    public function get(string $identifier): DependencyNode
    {
        return $this->nodes[$identifier];
    }

    /**
     * @return array<string, DependencyNode>
     */
    public function all(): array
    {
        return $this->nodes;
    }
}
