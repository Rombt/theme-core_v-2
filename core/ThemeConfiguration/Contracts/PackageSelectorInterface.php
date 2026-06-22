<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\PackageId;
use Rombt\ThemeCore\ThemeConfiguration\SelectedPackage;

interface PackageSelectorInterface
{
    public function select(
        PackageId $id,
    ): SelectedPackage;
}
