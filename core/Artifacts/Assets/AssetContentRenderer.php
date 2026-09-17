<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Assets;

use Rombt\ThemeCore\Artifacts\Assets\Contracts\AssetContentRendererInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;

final readonly class AssetContentRenderer implements
    AssetContentRendererInterface
{
    public function render(
        Asset $asset,
        string $content,
    ): string {
        return $content;
    }
}
