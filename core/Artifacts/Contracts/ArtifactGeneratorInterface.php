<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Theme\ThemeDefinition;

interface ArtifactGeneratorInterface
{
    public function generate(
        ThemeDefinition $theme,
        ArtifactCollectionInterface $artifacts
    ): void;
}
