<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Assets;

final readonly class AssetResourceFile
{
    public function __construct(
        private string $path,
        private ?string $destPath = null,
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }

    public function destPath(): ?string
    {
        return $this->destPath;
    }
}
