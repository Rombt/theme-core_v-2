<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Assets;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetCollection;

final readonly class AssetsIr
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
