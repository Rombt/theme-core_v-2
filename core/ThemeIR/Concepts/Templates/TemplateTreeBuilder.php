<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNode;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNodeCollection;

final class TemplateTreeBuilder
{
    public function build(
        CompositionNodeCollection $nodes,
    ): TemplateTree {
        $roots = [];

        foreach ($nodes as $node) {
            $roots[] = $this->buildNode($node);
        }

        return new TemplateTree($roots);
    }

    private function buildNode(
        CompositionNode $node,
    ): TemplateNode {
        $children = [];

        foreach ($node->children() as $child) {
            $children[] = $this->buildNode($child);
        }

        return new TemplateNode(
            source: $node,
            children: $children,
        );
    }
}
