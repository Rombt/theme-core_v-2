<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Entities;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class EntitiesConfiguration implements
    ConfigurationDomainInterface,
    IrExportableInterface
{
    public function __construct(
        private array $entities,
    ) {
    }

    public function entities(): array
    {
        return $this->entities;
    }

    public function toArray(): array
    {
        return $this->entities;
    }
}
