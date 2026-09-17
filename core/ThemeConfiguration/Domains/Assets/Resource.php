<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

final readonly class Resource
{
    /**
     * @param iterable<ResourceFile> $files
     */
    public function __construct(
        private string $path,
        iterable $files = [],
    ) {
        $this->files = is_array($files)
            ? $files
            : iterator_to_array($files);
    }

    /**
     * @var array<ResourceFile>
     */
    private array $files;

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return array<ResourceFile>
     */
    public function files(): array
    {
        return $this->files;
    }
}
