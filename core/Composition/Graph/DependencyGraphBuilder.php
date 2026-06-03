<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Graph;

use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;

final class DependencyGraphBuilder
{
    public function build(
        ServiceRegistryInterface $registry
    ): DependencyGraph {
        $nodes = [];

        foreach ($registry->all() as $definition) {
            $nodes[$definition->getIdentifier()] = new DependencyNode(
                $definition->getIdentifier(),
                $definition->getDependencies()
            );
        }

        return new DependencyGraph($nodes);
    }
}
