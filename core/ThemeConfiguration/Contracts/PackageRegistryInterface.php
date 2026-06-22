<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\PackageId;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistration;

interface PackageRegistryInterface
{
    public function has(
        PackageId $id,
    ): bool;

    public function get(
        PackageId $id,
    ): ThemePackageRegistration;

    /**
     * @return array<string, ThemePackageRegistration>
     */
    public function all(): array;
}
