<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactSourcesInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;

final readonly class ThemeArtifactGenerator implements ThemeArtifactGeneratorInterface
{
    public function __construct(private ArtifactGeneratorRegistry $registry)
    {
    }

    public function generate(
        ArtifactSourcesInterface $sources,
        ArtifactCollectionInterface $artifacts,
    ): void {

        foreach ($this->registry->all() as $generator) {
            $source = $sources->get($generator->source());

            if ($source === null) {
                continue;
            }

            $generator->generate(
                $source,
                $artifacts,
            );
        }
    }
}
