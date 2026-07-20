<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;

final readonly class CompositionCollectionBuilder
{
    public function build(
        CompositionsConfiguration $configuration,
    ): CompositionCollection {
        $collection = new CompositionCollection();

        // Первый проход — создаём все Composition.
        foreach ($configuration->compositions() as $id => $definition) {
            $collection->add(
                new Composition(
                    id: $id,
                    type: $definition['type'],
                ),
            );
        }

        // Второй проход — строим дерево узлов.
        foreach ($configuration->compositions() as $id => $definition) {
            $composition = $collection->find($id);

            if ($composition === null) {
                throw new RuntimeException(
                    sprintf('Composition "%s" not found.', $id),
                );
            }

            $composition->setNodes(
                $this->buildNodes(
                    $definition['children'] ?? [],
                ),
            );
        }

        // Третий проход — разрешаем ссылки.
        foreach ($collection as $composition) {
            $this->resolveReferences(
                $composition->nodes(),
                $collection,
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

    private function resolveReferences(
        CompositionNodeCollection $nodes,
        CompositionCollection $compositions,
    ): void {
        foreach ($nodes as $node) {
            $composition = $compositions->find(
                $node->id(),
            );

            if ($composition !== null) {
                $node->setComposition(
                    $composition,
                );
            }

            $this->resolveReferences(
                $node->children(),
                $compositions,
            );
        }
    }
}
