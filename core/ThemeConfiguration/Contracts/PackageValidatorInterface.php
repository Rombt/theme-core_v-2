<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\LoadedPackage;

interface PackageValidatorInterface
{
    public function validate(LoadedPackage $package): void;
}
