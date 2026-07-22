<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

final readonly class Resource
{
    public function __construct(
        private string $type,
        private string $id,
    ) {
    }

    public function type(): string
    {
        return $this->type;
    }

    public function id(): string
    {
        return $this->id;
    }
}
