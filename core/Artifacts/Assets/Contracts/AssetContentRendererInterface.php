<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Assets\Contracts;

use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;

interface AssetContentRendererInterface
{
    public function render(
        Asset $asset,
        string $content,
    ): string;
}
