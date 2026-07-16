<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\WordPress\Assets;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetCollection;

final class AssetRegistrationBuilder
{
    public function build(
        AssetCollection $assets,
    ): AssetRegistrationCollection {
        $registrations = [];

        foreach ($assets as $asset) {
            $registrations[] = new AssetRegistration(
                handle: $asset->id(),
                type: $asset->type(),
                source: $asset->entry(),
                dependencies: $asset->dependencies(),
            );
        }

        return new AssetRegistrationCollection(
            $registrations,
        );
    }
}
