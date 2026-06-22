<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\LoadedPackage;
use Rombt\ThemeCore\ThemeConfiguration\SelectedPackage;

interface PackageLoaderServiceInterface
{
    public function load(
        SelectedPackage $package,
    ): LoadedPackage;
}
