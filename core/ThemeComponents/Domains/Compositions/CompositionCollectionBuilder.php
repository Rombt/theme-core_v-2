<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionDefinition;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;

final readonly class CompositionCollectionBuilder
{
    public function build(
        CompositionsConfiguration $configuration,
    ): CompositionCollection {
        $collection = new CompositionCollection();

        foreach ($configuration->compositions() as $id => $definition) {
            new Composition(
                id: $id,
                type: $definition['type'],
                nodes: $this->buildNodes($definition['children'] ?? []),
            );
        }

        return $collection;
    }

    /**
     * @param array<int, string|array{id:string, children?:array}> $children
     */
    private function buildNodes(
        array $children,
    ): CompositionNodeCollection {
        $collection = new CompositionNodeCollection();

        foreach ($children as $child) {
            if (is_string($child)) {
                $collection->add(
                    new CompositionNode(
                        id: $child,
                        children: new CompositionNodeCollection(),
                    ),
                );

                continue;
            }

            $collection->add(
                new CompositionNode(
                    id: $child['id'],
                    children: $this->buildNodes(
                        $child['children'] ?? [],
                    ),
                ),
            );
        }

        return $collection;
    }
}
