<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageDiscoveryInterface;

final readonly class ThemePackageRegistryProvider
{
    public function __construct(
        private PackageDiscoveryInterface $discovery,
        private ThemePackageRegistryBuilder $builder,
    ) {
    }

    public function provide($packagesPath): ThemePackageRegistry
    {
        return $this->builder->build($this->discovery->discover($packagesPath));
    }
}
