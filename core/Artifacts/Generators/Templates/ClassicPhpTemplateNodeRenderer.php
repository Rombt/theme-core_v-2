<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;

final readonly class ClassicPhpTemplateNodeRenderer implements TemplateNodeRendererInterface
{
    /**
     * @param iterable<NodeRendererInterface> $renderers
     */
    public function __construct(
        private iterable $renderers,
    ) {
    }

    public function render(
        TemplateNode $node,
    ): string {
        $source = $node->source();

        if (!$source->referencesNode()) {
            return '';
        }

        $resolvedNode = $source->node();

        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($resolvedNode)) {
                return $renderer->render($resolvedNode);
            }
        }

        return '';
    }
}
