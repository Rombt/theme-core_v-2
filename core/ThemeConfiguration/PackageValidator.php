<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageValidatorInterface;

final class PackageValidator implements PackageValidatorInterface
{
    public function validate(LoadedPackage $package): void
    {
        // TODO: validation will be implemented later
    }
}
