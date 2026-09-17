<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Assets;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;

final readonly class AssetsComponent implements ThemeComponentInterface
{
    public function __construct(
        private AssetCollection $assets,
    ) {
    }

    public function assets(): AssetCollection
    {
        return $this->assets;
    }
}
