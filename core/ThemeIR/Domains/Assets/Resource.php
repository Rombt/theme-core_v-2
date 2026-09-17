<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

final readonly class Resource
{
    /**
     * @param list<ResourceFile> $files
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
     * @return list<ResourceFile>
     */
    public function files(): array
    {
        return $this->files;
    }
}
