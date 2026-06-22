<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistry;

interface ThemePackageRegistryBuilderInterface
{
    public function build(
        iterable $packages,
    ): ThemePackageRegistry;
}
