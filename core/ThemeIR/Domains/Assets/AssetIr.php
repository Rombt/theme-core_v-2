<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Domains\Assets;

final readonly class AssetIr
{
    public function __construct(
        private string $id,
        private string $path,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function path(): string
    {
        return $this->path;
    }
}
