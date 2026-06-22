<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Contracts;

use Rombt\ThemeCore\Theme\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;

interface ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool;

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent;
}
