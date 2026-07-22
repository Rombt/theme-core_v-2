<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

final readonly class NodeType
{
    public function __construct(
        private string $name,
        private string $strategy = 'default',
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function strategy(): string
    {
        return $this->strategy;
    }
}
