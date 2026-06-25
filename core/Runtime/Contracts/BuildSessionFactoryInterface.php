<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Theme\ThemeDefinition;

interface BuildSessionFactoryInterface
{
    public function create(
        ThemeDefinition $theme,
    ): BuildSession;
}
