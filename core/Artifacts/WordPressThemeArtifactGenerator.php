<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Configuration\Configuration;

final class WordPressThemeArtifactGenerator implements ArtifactGeneratorInterface
{
    public function generate(
        Configuration $configuration,
        ArtifactCollectionInterface $artifacts
    ): void {
        $artifacts->add(
            new Artifact(
                id: new ArtifactId('style-css'),
                type: ArtifactType::FILE,
                destination: 'style.css',
                content: $this->generateStyleCss($configuration),
            )
        );
    }

    private function generateStyleCss(
        Configuration $configuration
    ): string {
        $name = (string) $configuration->get('theme.name');

        return <<<CSS
/*
Theme Name: {$name}
*/
CSS;
    }
}
