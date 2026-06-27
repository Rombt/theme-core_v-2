<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderServiceInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderInterface;

final class PackageLoaderService implements PackageLoaderServiceInterface
{
    public function __construct(private PackageLoaderInterface $loader)
    {
    }

    public function load(SelectedPackage $package): LoadedPackage
    {
        return new LoadedPackage(
            package: $this->loader->load($package->registration())
        );
    }
}
