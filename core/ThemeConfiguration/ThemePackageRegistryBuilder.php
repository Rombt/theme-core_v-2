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
            $registration = new ThemePackageRegistration($package);

            $registrations[$registration->id()->value()] = $registration;
        }

        return new ThemePackageRegistry($registrations);
    }
}
