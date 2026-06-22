<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final class ThemePackageRegistryBuilder
{
    /**
     * @param iterable<DiscoveredPackage> $packages
     */
    public function build(
        iterable $packages,
    ): ThemePackageRegistry {
        $registrations = [];

        foreach ($packages as $package) {
            $registrations[$package->id()->value()] =
                new ThemePackageRegistration(
                    id: $package->id(),
                    metadata: $package->metadata(),
                    loader: $package->loader(),
                );
        }

        return new ThemePackageRegistry(
            registrations: $registrations,
        );
    }
}
