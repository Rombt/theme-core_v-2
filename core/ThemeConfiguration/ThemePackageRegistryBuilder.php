<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemePackageRegistryBuilderInterface;

final class ThemePackageRegistryBuilder implements ThemePackageRegistryBuilderInterface
{
    /**
     * @param iterable<DiscoveredPackage> $packages
     */
    public function build(iterable $packages): ThemePackageRegistry
    {
        $registrations = [];

        foreach ($packages as $package) {
            $registrations[$package->id()->value()] =
                new ThemePackageRegistration(
                    id: $package->id(),
                    metadata: $package->metadata(),
                    configuration: $package->configuration(),
                    path: $package->path(),
                );
        }

        return new ThemePackageRegistry(
            $registrations,
        );
    }
}
