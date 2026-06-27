<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistration;

interface PackageLoaderInterface
{
    public function load(
        ThemePackageRegistration $registration,
    ): ThemeConfigurationPackage;
}
