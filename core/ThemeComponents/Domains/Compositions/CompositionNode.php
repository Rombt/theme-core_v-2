<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

final readonly class CompositionNode
{
    public function __construct(
        private string $id,
        private ?string $nodeId,
        private ?string $compositionId,
        private ?int $slot,
        private CompositionNodeCollection $overrides,
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

    public function slot(): ?int
    {
        return $this->slot;
    }

    public function overrides(): CompositionNodeCollection
    {
        return $this->overrides;
    }
}
