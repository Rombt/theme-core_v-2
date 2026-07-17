<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Integrations;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations\IntegrationsConfiguration;

final readonly class IntegrationsComponent implements ThemeComponentInterface
{
    public function __construct(
        private IntegrationsConfiguration $integrations,
    ) {
    }

    public function integrations(): IntegrationsConfiguration
    {
        return $this->integrations;
    }
}
