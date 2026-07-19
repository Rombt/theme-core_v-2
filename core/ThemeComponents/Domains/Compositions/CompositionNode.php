<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

final readonly class CompositionNode
{
    public function __construct(
        private string $id,
        private CompositionNodeCollection $children,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function children(): CompositionNodeCollection
    {
        return $this->children;
    }
}
