<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

interface SelectedPackageProviderInterface
{
    public function provide(): ThemeConfigurationPackage;
}
