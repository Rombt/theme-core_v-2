<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ResolvedResource;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Node;

final readonly class TemplateNode
{
    /**
     * @param list<TemplateNode> $children
     */
    public function __construct(
        private ?Node $node,
        private ?ResolvedResource $resource,
        private array $children = [],
    ) {
    }

    public function referencesNode(): bool
    {
        return $this->node !== null;
    }

    public function node(): ?Node
    {
        return $this->node;
    }

    public function resource(): ?ResolvedResource
    {
        return $this->resource;
    }

    /**
     * @return list<TemplateNode>
     */
    public function children(): array
    {
        return $this->children;
    }
}
