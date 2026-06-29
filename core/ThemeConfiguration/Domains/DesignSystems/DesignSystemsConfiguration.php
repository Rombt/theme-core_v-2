<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class DesignSystemsConfiguration implements
    ConfigurationDomainInterface,
    IrExportableInterface
{
    public function __construct(
        private array $designSystems,
    ) {
    }

    public function designSystems(): array
    {
        return $this->designSystems;
    }

    public function toArray(): array
    {
        return $this->designSystems;
    }
}
