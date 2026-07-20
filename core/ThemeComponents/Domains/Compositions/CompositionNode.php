<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

final class CompositionNode
{
    private ?Composition $composition;

    public function __construct(
        private readonly string $id,
        private readonly CompositionNodeCollection $children,
        ?Composition $composition = null,
    ) {
        $this->composition = $composition;
    }

    public function id(): string
    {
        return $this->id;
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
}
