<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\Theme\ThemeDefinition;

final readonly class ThemeArtifactGenerator implements ThemeArtifactGeneratorInterface
{
    public function __construct(private ArtifactGeneratorRegistry $registry)
    {
    }

    public function generate(ThemeDefinition $theme, ArtifactCollectionInterface $artifacts): void
    {
        $ir = $theme->ir();

        foreach ($this->registry->all() as $generator) {
            $generator->generate($ir, $artifacts);
        }
    }
}
