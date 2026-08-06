<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ValueObjects\ResourceArchitecture;

final readonly class ResolvedResourceArchitecture
{
    public function __construct(
        private ResourceArchitecture $architecture,
        private bool $exists,
        private string $absolutePath,
        private string $relativePath,
    ) {
    }

    public function architecture(): ResourceArchitecture
    {
        return $this->architecture;
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
}
