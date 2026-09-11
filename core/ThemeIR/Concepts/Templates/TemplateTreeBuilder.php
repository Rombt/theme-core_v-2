<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Templates;

use LogicException;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Composition;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNode;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNodeCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodeCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\ValueObjects\TemplateNodeType;

final readonly class TemplateTreeBuilder
{
    public function __construct(
        private NodeCollection $nodes,
        private CompositionCollection $compositions,
        private NodeFunctionDefinitionCollection $functionDefinitions,
    ) {
    }

    public function build(Composition $composition): TemplateTree
    {
        return new TemplateTree(
            roots: [
                $this->buildComposition($composition),
            ],
        );
    }

    /**
     * @return list<TemplateNode>
     */
    private function buildNodes(CompositionNodeCollection $nodes): array
    {
        $result = [];

        foreach ($nodes as $node) {
            $result[] = $this->buildNode($node);
        }

        return $result;
    }

    private function buildNode(
        CompositionNode $compositionNode,
    ): TemplateNode {
        if ($compositionNode->nodeId() !== null) {
            return $this->buildNodeReference($compositionNode);
        }

        if ($compositionNode->compositionId() !== null) {
            return $this->buildCompositionReference($compositionNode);
        }

        throw new LogicException(
            sprintf(
                'Composition node "%s" must reference a node or composition.',
                $compositionNode->id(),
            ),
        );
    }

    private function buildNodeReference(
        CompositionNode $compositionNode,
    ): TemplateNode {
        $node = $this->nodes->find($compositionNode->nodeId());

        if ($node === null) {
            throw new LogicException(
                sprintf(
                    'Node "%s" not found.',
                    $compositionNode->nodeId(),
                ),
            );
        }

        return new TemplateNode(
            id: $compositionNode->id(),
            nodeId: $node->id(),
            compositionId: null,
            type: new TemplateNodeType(
                $node->type()->name(),
            ),
            resource: $node->resource() !== null
                ? new Resource($node->resource())
                : null,
            function: $this->functionDefinitions->find(
                $node->id(),
            ),
            rendering: $node->rendering(),
            slot: $compositionNode->slot(),
        );
    }

    private function buildCompositionReference(
        CompositionNode $compositionNode,
    ): TemplateNode {
        $composition = $this->compositions->find(
            $compositionNode->compositionId(),
        );

        if ($composition === null) {
            throw new LogicException(
                sprintf(
                    'Composition "%s" not found.',
                    $compositionNode->compositionId(),
                ),
            );
        }

        $children = $compositionNode->overrides()->isEmpty()
            ? $composition->defaultChildren()
            : $compositionNode->overrides();

        return new TemplateNode(
            id: $compositionNode->id(),
            nodeId: null,
            compositionId: $composition->id(),
            type: new TemplateNodeType(
                $composition->type()->name(),
            ),
            resource: $composition->resource() !== null
                ? new Resource($composition->resource())
                : null,
            function: null,
            rendering: $composition->rendering(),
            slot: $compositionNode->slot(),
            children: $this->buildNodes($children),
        );
    }

    private function buildComposition(
        Composition $composition,
    ): TemplateNode {
        return new TemplateNode(
            id: $composition->id(),
            nodeId: null,
            compositionId: $composition->id(),
            type: new TemplateNodeType(
                $composition->type()->name(),
            ),
            resource: $composition->resource() !== null
            ? new Resource($composition->resource())
            : null,
            function: null,
            rendering: $composition->rendering(),
            slot: null,
            children: $this->buildNodes(
                $composition->defaultChildren(),
            ),
        );
    }
}
