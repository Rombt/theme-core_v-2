<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistration;

interface DomainRegistryInterface
{
    public function has(
        DomainId $id,
    ): bool;

    public function get(
        DomainId $id,
    ): DomainRegistration;

    /**
     * @return array<string, DomainRegistration>
     */
    public function all(): array;
}
