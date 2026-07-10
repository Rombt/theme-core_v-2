<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

interface AssetRendererInterface
{
    /**
     * @param array<string, array<string, mixed>> $assets
     */
    public function render(
        array $assets,
    ): string;
}
