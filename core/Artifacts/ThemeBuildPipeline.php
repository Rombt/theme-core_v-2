<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionFactoryInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactWriterInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIr;

final readonly class ThemeBuildPipeline
{
    public function __construct(
        private ThemeArtifactGeneratorInterface $generator,
        private ArtifactCollectionFactoryInterface $collectionFactory,
        private ArtifactWriterInterface $writer,
    ) {
    }

    public function build(ThemeIr $themeIr): void
    {
        $artifacts = $this->collectionFactory->create();

        $this->generator->generate(
            $themeIr,
            $artifacts,
        );

        $this->writer->write($artifacts);
    }
}
