<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

final readonly class Resource
{
    public function __construct(
        private string $type,
        private string $id,
        private string $classic,
        private string $block,
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

    public function classic(): string
    {
        return $this->classic;
    }

    public function block(): string
    {
        return $this->block;
    }
}
