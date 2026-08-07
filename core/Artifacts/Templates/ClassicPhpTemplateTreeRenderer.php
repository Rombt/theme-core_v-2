<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateTree;

final readonly class ClassicPhpTemplateTreeRenderer
{
    public function __construct(
        private TemplateNodeRendererInterface $nodeRenderer,
    ) {
    }

    public function render(TemplateTree $tree): string
    {
        return $this->renderNode($tree->root());
    }

    private function renderNode(TemplateNode $node): string
    {
        $output = $this->nodeRenderer->render($node);

        foreach ($node->children() as $child) {
            $output .= $this->renderNode($child);
        }

        return $output;
    }
}
