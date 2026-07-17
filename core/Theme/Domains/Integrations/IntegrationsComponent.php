<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Domains\Integrations;

use Rombt\ThemeCore\Theme\Contracts\ThemeComponentInterface;
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
