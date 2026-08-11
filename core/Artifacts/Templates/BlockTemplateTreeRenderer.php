<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateTree;

final readonly class BlockTemplateTreeRenderer implements TemplateTreeRendererInterface
{
    public function render(TemplateTree $tree): string
    {
        $parts = [];

        foreach ($tree->roots() as $node) {
            $parts[] = $this->renderNode($node);
        }

        return implode("\n", $parts);
    }

    private function renderNode(TemplateNode $node): string
    {
        $content = $this->renderResource($node);

        foreach ($node->children() as $child) {
            $content .= $this->renderNode($child);
        }

        return $content;
    }

    private function renderResource(TemplateNode $node): string
    {
        throw new \LogicException(
            'Block TemplateNode resource rendering is not implemented yet.',
        );
    }
}
