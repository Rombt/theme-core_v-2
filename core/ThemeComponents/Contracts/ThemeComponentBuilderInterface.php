<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;

interface ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool;

    public function build(
        ConfigurationDomain $domain,
        ThemeComponentCollection $components,
    ): ThemeComponent;
}
