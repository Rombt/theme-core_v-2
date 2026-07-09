<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final readonly class SelectedPackage
{
    public function __construct(
        private ThemePackageRegistration $registration,
    ) {
    }

    public function registration(): ThemePackageRegistration
    {
        return $this->registration;
    }

    public function id(): PackageId
    {
        return $this->registration->id();
    }
}
