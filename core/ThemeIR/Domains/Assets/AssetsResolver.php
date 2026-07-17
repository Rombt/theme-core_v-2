<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetCollection;

final readonly class AssetsResolver
{
    public function resolve(ThemeComponentCollection $components): AssetsIR
    {
        foreach ($components as $component) {
            if ($component instanceof AssetsComponent) {
                return new AssetsIR($component->assets());
            }
        }

        return new AssetsIR(
            new AssetCollection(),
        );
    }
}
