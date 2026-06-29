<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class IntegrationsConfiguration implements
    ConfigurationDomainInterface,
    IrExportableInterface
{
    public function __construct(
        private array $integrations,
    ) {
    }

    public function integrations(): array
    {
        return $this->integrations;
    }

    public function toArray(): array
    {
        return $this->integrations;
    }
}
