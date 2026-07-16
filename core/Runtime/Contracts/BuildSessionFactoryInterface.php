<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

interface BuildSessionFactoryInterface
{
    public function create(
        ThemeConfigurationPackage $package,
    ): BuildSession;
}
