<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIr;

final readonly class ThemeArtifactGenerator implements ThemeArtifactGeneratorInterface
{
    public function __construct(
        private ArtifactGeneratorRegistry $registry,
    ) {
    }

    public function generate(
        ThemeIr $themeIr,
        ArtifactCollectionInterface $artifacts,
    ): void {
        foreach ($themeIr->all() as $concept) {
            foreach ($this->registry->all() as $generator) {
                if ($concept instanceof ($generator->supports())) {
                    $generator->generate($concept, $artifacts);
                }
            }
        }
    }
}
