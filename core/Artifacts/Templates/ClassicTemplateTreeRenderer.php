<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use LogicException;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateTree;

final readonly class ClassicTemplateTreeRenderer implements TemplateTreeRendererInterface
{
    public function __construct(
        private TemplateResourceContentReaderInterface $resourceContentReader,
    ) {
    }

    public function render(TemplateTree $tree): string
    {
        $parts = [];

        foreach ($tree->roots() as $node) {
            $content = $this->renderNode($node);

            if ($content !== '') {
                $parts[] = $content;
            }
        }

        return implode(PHP_EOL, $parts);
    }

    private function renderNode(TemplateNode $node): string
    {
        if ($node->referencesComposition()) {
            return $this->renderChildren($node);
        }

        if (!$node->referencesNode()) {
            return '';
        }

        $path = $node->classic();

        if ($path === '') {
            return '';
        }

        $content = $this->resourceContentReader->read($path);

        return $this->replaceSlots(
            $content,
            $node,
            $path,
        );
    }

    private function renderChildren(TemplateNode $node): string
    {
        $parts = [];

        foreach ($node->children() as $child) {
            $content = $this->renderNode($child);

            if ($content !== '') {
                $parts[] = $content;
            }
        }

        return implode(PHP_EOL, $parts);
    }

    private function replaceSlots(
        string $content,
        TemplateNode $node,
        string $path,
    ): string {
        foreach ($node->children() as $child) {
            $childContent = $this->renderNode($child);

            if ($childContent === '') {
                continue;
            }

            $slot = $child->slot();

            if ($slot === null) {
                throw new LogicException(
                    sprintf(
                        'TemplateNode child of "%s" does not define a slot.',
                        $path,
                    ),
                );
            }

            $slotMarker = '@slot_' . $slot;

            if (!str_contains($content, $slotMarker)) {
                throw new LogicException(
                    sprintf(
                        'Template resource "%s" does not contain expected slot "%s".',
                        $path,
                        $slotMarker,
                    ),
                );
            }

            $content = str_replace(
                $slotMarker,
                $childContent,
                $content,
            );
        }

        return $content;
    }
}
