<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionFactoryInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactWriterInterface;
use Rombt\ThemeCore\Theme\ThemeDefinition;

final readonly class ThemeBuildPipeline
{
    public function __construct(
        private ThemeArtifactGenerator $generator,
        private ArtifactCollectionFactoryInterface $collectionFactory,
        private ArtifactWriterInterface $writer,
    ) {
    }

    public function build(ThemeDefinition $theme): void
    {
        $artifacts = $this->collectionFactory->create();

        $this->generator->generate($theme, $artifacts);

        $this->writer->write($artifacts);
    }
}
