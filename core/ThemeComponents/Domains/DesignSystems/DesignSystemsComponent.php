<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\DesignSystems;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsConfiguration;

final readonly class DesignSystemsComponent implements ThemeComponentInterface
{
    public function __construct(
        private DesignSystemsConfiguration $designSystems,
    ) {
    }

    public function designSystems(): DesignSystemsConfiguration
    {
        return $this->designSystems;
    }
}
