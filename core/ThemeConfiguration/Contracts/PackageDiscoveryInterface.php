<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\DiscoveredPackage;

interface PackageDiscoveryInterface
{
    /**
     * @return iterable<DiscoveredPackage>
     */
    public function discover(string $packagesPath): iterable;
}
