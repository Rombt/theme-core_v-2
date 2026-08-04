<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Integrations;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations\IntegrationsConfiguration;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeConcept;

final readonly class IntegrationIr extends ThemeConcept
{
    public function __construct(
        IrId $id,
        private IntegrationsConfiguration $configuration,
    ) {
        parent::__construct($id);
    }

    public function configuration(): IntegrationsConfiguration
    {
        return $this->configuration;
    }
}
