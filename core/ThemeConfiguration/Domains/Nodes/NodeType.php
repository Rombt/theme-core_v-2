<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

final readonly class NodeType
{
    public function __construct(
        private string $value,
    ) {
    }

    public function value(): string
    {
        return $this->value;
    }
}
