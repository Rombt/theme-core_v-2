<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNode;

final readonly class TemplateNode
{
    /**
     * @param list<TemplateNode> $children
     */
    public function __construct(
        private CompositionNode $source,
        private array $children = [],
    ) {
    }

    public function source(): CompositionNode
    {
        return $this->source;
    }

    /**
     * @return list<TemplateNode>
     */
    public function children(): array
    {
        return $this->children;
    }
}
