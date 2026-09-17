<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Assets;

final readonly class AssetResource
{
    /**
     * @param list<AssetResourceFile> $files
     */
    public function __construct(
        private string $path,
        private array $files = [],
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return list<AssetResourceFile>
     */
    public function files(): array
    {
        return $this->files;
    }
}
