<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\DomainId;

interface DomainProviderInterface
{
    public function has(
        DomainId $id,
    ): bool;

    public function get(
        DomainId $id,
    ): ConfigurationDomainInterface;
}
