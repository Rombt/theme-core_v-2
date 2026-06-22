<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderServiceInterface;

final class PackageLoaderService implements PackageLoaderServiceInterface
{
    public function load(
        SelectedPackage $package,
    ): LoadedPackage {
        return new LoadedPackage(
            package: $package
                ->registration()
                ->loader()
                ->load(),
        );
    }
}
