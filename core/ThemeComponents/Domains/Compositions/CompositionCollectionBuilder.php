<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodeCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Exceptions\UnknownCompositionNodeException;

final readonly class CompositionCollectionBuilder
{
    public function build(
        CompositionsConfiguration $configuration,
        NodeCollection $nodes,
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
                $nodes,
            );
        }

        return $collection;
    }

    /**
     * @param array<int, array{
     *     id:string,
     *     node?:string,
     *     slot?:int,
     *     children?:array
     * }> $children
     */
    private function buildNodes(
        array $children,
    ): CompositionNodeCollection {
        $collection = new CompositionNodeCollection();

        foreach ($children as $child) {
            if (!is_array($child)) {
                throw new RuntimeException(
                    sprintf(
                        'Invalid placement. Expected array, got %s: %s',
                        gettype($child),
                        var_export($child, true),
                    ),
                );
            }


            $collection->add(
                new CompositionNode(
                    id: $child['id'],
                    nodeId: $child['node'] ?? null,
                    slot: $child['slot'] ?? null,
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
        NodeCollection $registeredNodes,
    ): void {
        foreach ($nodes as $node) {
            $composition = $compositions->find(
                $node->id(),
            );

            if ($composition !== null) {
                $node->setComposition($composition);

                $this->resolveReferences(
                    $node->children(),
                    $compositions,
                    $registeredNodes,
                );

                continue;
            }

            if ($node->nodeId() !== null) {
                $registeredNode = $registeredNodes->find(
                    $node->nodeId(),
                );

                if ($registeredNode === null) {
                    throw UnknownCompositionNodeException::forId(
                        $node->nodeId(),
                    );
                }

                $node->setNode($registeredNode);
            }

            $this->resolveReferences(
                $node->children(),
                $compositions,
                $registeredNodes,
            );
        }
    }
}
