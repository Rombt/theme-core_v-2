<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNode;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNodeCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ResolvedResource;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Node;

final class TemplateTreeBuilder
{
    /**
     * @param callable(Node): ResolvedResource $nodeResolver
     */
    public function build(
        CompositionNodeCollection $nodes,
        callable $nodeResolver,
    ): TemplateTree {
        return new TemplateTree(
            $this->buildNodes($nodes, $nodeResolver),
        );
    }

    /**
     * @param callable(Node): ResolvedResource $nodeResolver
     * @return list<TemplateNode>
     */
    private function buildNodes(
        CompositionNodeCollection $nodes,
        callable $nodeResolver,
    ): array {
        $result = [];

        foreach ($nodes as $node) {
            foreach ($this->buildNode($node, $nodeResolver) as $templateNode) {
                $result[] = $templateNode;
            }
        }

        return $result;
    }

    /**
     * @param callable(Node): ResolvedResource $nodeResolver
     * @return list<TemplateNode>
     */
    private function buildNode(
        CompositionNode $compositionNode,
        callable $nodeResolver,
    ): array {
        if ($compositionNode->referencesComposition()) {
            $composition = $compositionNode->composition();

            if ($composition === null) {
                return [];
            }

            return [
                new TemplateNode(
                    node: null,
                    resource: null,
                    composition: $composition,
                    slot: $compositionNode->slot(),
                    children: $this->buildNodes(
                        $composition->nodes(),
                        $nodeResolver,
                    ),
                ),
            ];
        }

        $node = $compositionNode->node();

        if ($node === null) {
            return [];
        }

        return [
            new TemplateNode(
                node: $node,
                resource: $nodeResolver($node),
                slot: $compositionNode->slot(),
                children: $this->buildNodes(
                    $compositionNode->children(),
                    $nodeResolver,
                ),
            ),
        ];
    }
}
