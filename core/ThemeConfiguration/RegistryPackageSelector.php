<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageRegistryInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageSelectorInterface;

final readonly class RegistryPackageSelector implements PackageSelectorInterface
{
    public function __construct(
        private PackageRegistryInterface $registry,
    ) {
    }

    public function select(
        PackageId $id,
    ): SelectedPackage {
        return new SelectedPackage(
            registration: $this->registry->get($id),
        );
    }
}
