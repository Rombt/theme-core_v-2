<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\ThemeIR\ThemeIr;

interface ThemeArtifactGeneratorInterface
{
    public function generate(
        ThemeIr $themeIr,
        ArtifactCollectionInterface $artifacts,
    ): void;
}
