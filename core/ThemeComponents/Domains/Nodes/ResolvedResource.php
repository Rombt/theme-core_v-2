<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

final readonly class ResolvedResource
{
    public function __construct(
        private bool $exists,
        private string $absolutePath,
        private string $relativePath,
        private ResourceType $type,
    ) {
    }

    public function exists(): bool
    {
        return $this->exists;
    }

    public function absolutePath(): string
    {
        return $this->absolutePath;
    }

    public function relativePath(): string
    {
        return $this->relativePath;
    }

    public function type(): ResourceType
    {
        return $this->type;
    }
}
