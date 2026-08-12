<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use LogicException;
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

        return implode(PHP_EOL, $parts);
    }

    private function renderNode(TemplateNode $node): string
    {
        if (!$node->referencesNode()) {
            throw new LogicException(
                'TemplateNode does not reference a Node.',
            );
        }

        $content = $node->block();

        foreach ($node->children() as $child) {
            $childContent = $this->renderNode($child);

            if ($childContent === '') {
                continue;
            }

            if ($content !== '') {
                $content .= PHP_EOL;
            }

            $content .= $childContent;
        }

        return $content;
    }
}
