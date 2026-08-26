<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeComponents\Domains\Rendering\Rendering;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateNodeType;

final readonly class TemplateNode
{
    /**
     * @param list<TemplateNode> $children
     */
    public function __construct(
        private string $id,
        private ?string $nodeId,
        private ?string $compositionId,
        private ?TemplateNodeType $type,
        private ?Resource $resource,
        private Rendering $rendering,
        private ?int $slot,
        private array $children = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function nodeId(): ?string
    {
        return $this->nodeId;
    }

    public function compositionId(): ?string
    {
        return $this->compositionId;
    }

    public function type(): TemplateNodeType
    {
        return $this->type;
    }

    public function resource(): ?Resource
    {
        return $this->resource;
    }

    public function rendering(): Rendering
    {
        return $this->rendering;
    }

    public function slot(): ?int
    {
        return $this->slot;
    }

    /**
     * @return list<TemplateNode>
     */
    public function children(): array
    {
        return $this->children;
    }
}
