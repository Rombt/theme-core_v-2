<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

final readonly class Composition
{
    public function __construct(
        private string $id,
        private string $type,
        private CompositionNodeCollection $nodes,
    ) {
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
}
