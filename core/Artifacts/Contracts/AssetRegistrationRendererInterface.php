<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\WordPress\Assets\AssetRegistrationCollection;

interface AssetRegistrationRendererInterface
{
    public function render(
        AssetRegistrationCollection $registrations,
    ): string;
}
