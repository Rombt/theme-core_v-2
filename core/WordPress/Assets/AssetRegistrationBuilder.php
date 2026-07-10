<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\WordPress\Assets;

final class AssetRegistrationBuilder
{
    /**
     * @param array<string, array<string, mixed>> $assets
     */
    public function build(
        array $assets,
    ): AssetRegistrationCollection {
        $registrations = [];

        foreach ($assets as $handle => $asset) {
            $registrations[] = new AssetRegistration(
                handle: $handle,
                type: $asset['type'],
                source: $asset['entry'],
                dependencies: $asset['dependencies'],
            );
        }

        return new AssetRegistrationCollection(
            $registrations,
        );
    }
}
