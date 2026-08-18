<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\Domains\Rendering\Rendering;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;

final readonly class CompositionCollectionBuilder
{
    public function build(
        CompositionsConfiguration $configuration,
    ): CompositionCollection {
        $collection = new CompositionCollection();

        $this->buildDefinitions(
            $configuration,
            $collection,
        );

        $this->buildChildren(
            $configuration,
            $collection,
        );

        return $collection;
    }

    private function buildDefinitions(
        CompositionsConfiguration $configuration,
        CompositionCollection $collection,
    ): void {
        foreach ($configuration->compositions() as $id => $definition) {
            $rendering = $definition['rendering'] ?? null;

            if ($rendering !== null && !is_string($rendering)) {
                throw new RuntimeException(
                    sprintf(
                        'Composition "%s" rendering must be a string or null.',
                        $id,
                    ),
                );
            }

            $collection->add(
                new Composition(
                    id: $id,
                    resource: $definition['resource'] ?? null,
                    rendering: $rendering !== null
                        ? Rendering::from($rendering)
                        : null,
                ),
            );
        }
    }

    private function buildChildren(
        CompositionsConfiguration $configuration,
        CompositionCollection $collection,
    ): void {
        foreach ($configuration->compositions() as $id => $definition) {
            $composition = $collection->find($id);

            if ($composition === null) {
                throw new RuntimeException(
                    sprintf(
                        'Composition "%s" not found.',
                        $id,
                    ),
                );
            }

            $composition->setDefaultChildren(
                $this->buildChildrenCollection(
                    $definition['children'] ?? [],
                ),
            );
        }
    }

    /**
     * @param array<int, array<string, mixed>> $children
     */
    private function buildChildrenCollection(
        array $children,
    ): CompositionNodeCollection {
        $collection = new CompositionNodeCollection();

        foreach ($children as $child) {
            if (!is_array($child)) {
                throw new RuntimeException(
                    sprintf(
                        'Invalid composition child. Expected array, got %s.',
                        gettype($child),
                    ),
                );
            }

            $id = $child['id'] ?? null;
            $nodeId = $child['node'] ?? null;
            $compositionId = $child['composition'] ?? null;
            $slot = $child['slot'] ?? null;

            if (!is_string($id)) {
                throw new RuntimeException(
                    'Composition child id must be a string.',
                );
            }

            if ($nodeId !== null && !is_string($nodeId)) {
                throw new RuntimeException(
                    sprintf(
                        'Composition child "%s" node must be a string or null.',
                        $id,
                    ),
                );
            }

            if ($compositionId !== null && !is_string($compositionId)) {
                throw new RuntimeException(
                    sprintf(
                        'Composition child "%s" composition must be a string or null.',
                        $id,
                    ),
                );
            }

            if ($slot !== null && !is_int($slot)) {
                throw new RuntimeException(
                    sprintf(
                        'Composition child "%s" slot must be a string or null.',
                        $id,
                    ),
                );
            }

            if ($nodeId !== null && $compositionId !== null) {
                throw new RuntimeException(
                    sprintf(
                        'Composition child "%s" cannot reference both node and composition.',
                        $id,
                    ),
                );
            }

            if ($nodeId === null && $compositionId === null) {
                throw new RuntimeException(
                    sprintf(
                        'Composition child "%s" must reference a node or composition.',
                        $id,
                    ),
                );
            }

            $overrides = $compositionId !== null
                ? $this->buildChildrenCollection(
                    $child['children'] ?? [],
                )
                : new CompositionNodeCollection();

            $collection->add(
                new CompositionNode(
                    id: $id,
                    nodeId: $nodeId,
                    compositionId: $compositionId,
                    slot: $slot,
                    overrides: $overrides,
                ),
            );
        }

        return $collection;
    }
}
