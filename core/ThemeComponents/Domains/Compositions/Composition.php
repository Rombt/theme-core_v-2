<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

final class Composition
{
    private CompositionNodeCollection $nodes;

    public function __construct(
        private readonly string $id,
        private readonly string $type,
    ) {
        $this->nodes = new CompositionNodeCollection();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function nodes(): CompositionNodeCollection
    {
        return $this->nodes;
    }

    public function setNodes(
        CompositionNodeCollection $nodes,
    ): void {
        $this->nodes = $nodes;
    }

    public function isTemplatePart(): bool
    {
        return $this->type === 'template-part';
    }
}
