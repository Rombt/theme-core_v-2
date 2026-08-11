<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ResolvedResource;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Node;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ValueObjects\ResourceArchitecture;

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

    public function resource(): ?Resource
    {
        if ($this->resource === null) {
            return null;
        }

        return new Resource(
            type: $this->resource->resource()->type(),
            id: $this->resource->resource()->id(),
            classic: $this->resource->architecture(
                ResourceArchitecture::Classic,
            )?->absolutePath() ?? '',
            block: $this->resource->architecture(
                ResourceArchitecture::Block,
            )?->absolutePath() ?? '',
        );
    }

    /**
     * @return list<TemplateNode>
     */
    public function children(): array
    {
        return $this->children;
    }

    public function classic(): string
    {
        return $this->resource()?->classic() ?? '';
    }


    public function block(): string
    {
        return $this->resource()?->block() ?? '';
    }

    public function hasChildren(): bool
    {
        return $this->children !== [];
    }
}
