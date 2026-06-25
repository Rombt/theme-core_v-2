<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final readonly class ValidatedPackage
{
    public function __construct(
        private ThemeConfigurationPackage $package,
    ) {
    }

    public function package(): ThemeConfigurationPackage
    {
        return $this->package;
    }
}
