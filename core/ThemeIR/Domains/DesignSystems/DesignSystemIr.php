<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\DesignSystems;

use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsConfiguration;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeConcept;

final readonly class DesignSystemIr extends ThemeConcept
{
    public function __construct(
        IrId $id,
        private DesignSystemsConfiguration $configuration,
    ) {
        parent::__construct($id);
    }

    public function configuration(): DesignSystemsConfiguration
    {
        return $this->configuration;
    }
}
