<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

final readonly class ThemeArtifactGenerator implements ThemeArtifactGeneratorInterface
{
    public function __construct(
        private ArtifactGeneratorRegistry $registry,
    ) {
    }

    public function generate(
        ThemeIrCollection $collection,
        ArtifactCollectionInterface $artifacts,
    ): void {
        foreach ($collection as $ir) {
            foreach ($this->registry->all() as $generator) {
                if ($ir instanceof ($generator->supports())) {
                    $generator->generate($ir, $artifacts);
                }
            }
        }
    }
}
