<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

interface ThemeArtifactGeneratorInterface
{
    public function generate(
        ArtifactSourcesInterface $sources,
        ArtifactCollectionInterface $artifacts,
    ): void;
}
