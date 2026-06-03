<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Graph;

final class DependencyNode
{
    /**
     * @param string[] $dependencies
     */
    public function __construct(
        private string $identifier,
        private array $dependencies
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }
}
