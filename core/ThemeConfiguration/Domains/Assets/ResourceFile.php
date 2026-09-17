<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

final readonly class ResourceFile
{
    public function __construct(
        private string $path,
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }
}
