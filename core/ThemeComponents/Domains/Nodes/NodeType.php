<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

final readonly class NodeType
{
    public function __construct(
        private string $name,
        private NodeStrategy $strategy,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function strategy(): NodeStrategy
    {
        return $this->strategy;
    }
}
