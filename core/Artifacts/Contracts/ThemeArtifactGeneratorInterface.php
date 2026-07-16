<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Theme\ThemeIr;

interface ThemeArtifactGeneratorInterface
{
    public function generate(
        ThemeIr $ir,
        ArtifactCollectionInterface $artifacts,
    ): void;
}
