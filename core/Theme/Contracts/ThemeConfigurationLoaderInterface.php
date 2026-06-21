<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Contracts;

use Rombt\ThemeCore\Theme\ThemeConfiguration;

interface ThemeConfigurationLoaderInterface
{
    public function load(): ThemeConfiguration;
}
