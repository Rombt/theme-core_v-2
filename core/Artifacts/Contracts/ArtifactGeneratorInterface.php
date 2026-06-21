<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Configuration\Configuration;

interface ArtifactGeneratorInterface
{
    public function generate(
        Configuration $configuration,
        ArtifactCollectionInterface $artifacts
    ): void;
}
