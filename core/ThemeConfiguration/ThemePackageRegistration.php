<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemePackageInterface;

final readonly class ThemePackageRegistration implements ThemePackageInterface
{
    public function __construct(
        private ThemePackageInterface $package,
    ) {
    }

    public function id(): PackageId
    {
        return $this->package->id();
    }

    public function path(): string
    {
        return $this->package->path();
    }

    public function configuration(): array
    {
        return $this->package->configuration();
    }

    public function package(): ThemePackageInterface
    {
        return $this->package;
    }
}
