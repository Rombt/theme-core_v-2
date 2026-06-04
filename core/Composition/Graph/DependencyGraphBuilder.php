<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Graph;

use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;
use Rombt\ThemeCore\Composition\Exceptions\CompositionDefinitionNotFoundException;

final class DependencyGraphBuilder
{
    public function build(
        ServiceRegistryInterface $registry
    ): DependencyGraph {
        $nodes = [];

        foreach ($registry->all() as $definition) {
            foreach ($definition->getDependencies() as $dependency) {
                if (!$registry->has($dependency)) {
                    throw new CompositionDefinitionNotFoundException(
                        sprintf(
                            'Dependency definition "%s" was not found.',
                            $dependency
                        )
                    );
                }
            }

            $nodes[$definition->getIdentifier()] = new DependencyNode(
                $definition->getIdentifier(),
                $definition->getDependencies()
            );
        }

        return new DependencyGraph($nodes);
    }
}
