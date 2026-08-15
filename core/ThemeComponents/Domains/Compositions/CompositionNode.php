<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Node;

final class CompositionNode
{
    private ?Composition $composition;

    private ?Node $node;

    public function __construct(
        private readonly string $id,
        private readonly ?string $nodeId,
        private readonly ?int $slot,
        private readonly CompositionNodeCollection $children,
        ?Composition $composition = null,
        ?Node $node = null,
    ) {
        $this->composition = $composition;
        $this->node = $node;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function slot(): ?int
    {
        return $this->slot;
    }

    public function children(): CompositionNodeCollection
    {
        return $this->children;
    }

    public function referencesComposition(): bool
    {
        return $this->composition !== null;
    }

    public function composition(): ?Composition
    {
        return $this->composition;
    }

    public function setComposition(
        Composition $composition,
    ): void {
        $this->composition = $composition;
    }

    public function referencesNode(): bool
    {
        return $this->node !== null;
    }

    public function node(): ?Node
    {
        return $this->node;
    }

    public function setNode(
        Node $node,
    ): void {
        $this->node = $node;
    }

    public function nodeId(): ?string
    {
        return $this->nodeId;
    }
}
