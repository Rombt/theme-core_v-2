<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

interface ThemeArtifactGeneratorInterface
{
    public function generate(
        ThemeIrCollection $collection,
        ArtifactCollectionInterface $artifacts,
    ): void;
}
