<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Theme\ThemeConfiguration;

interface ArtifactGeneratorInterface
{
    public function generate(
        ThemeConfiguration $configuration,
        ArtifactCollectionInterface $artifacts
    ): void;
}
