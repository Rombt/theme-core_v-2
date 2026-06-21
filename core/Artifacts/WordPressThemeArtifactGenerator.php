<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Theme\ThemeConfiguration;

final class WordPressThemeArtifactGenerator implements ArtifactGeneratorInterface
{
    public function generate(
        ThemeConfiguration $configuration,
        ArtifactCollectionInterface $artifacts
    ): void {
        $themeName = (string) $configuration->get('name');

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('style-css'),
                type: ArtifactType::FILE,
                destination: 'style.css',
                content: <<<CSS
/*
Theme Name: {$themeName}
*/
CSS
            )
        );

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('functions-php'),
                type: ArtifactType::FILE,
                destination: 'functions.php',
                content: <<<'PHP'
<?php

declare(strict_types=1);
PHP
            )
        );

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('index-php'),
                type: ArtifactType::FILE,
                destination: 'index.php',
                content: <<<'PHP'
<?php

declare(strict_types=1);
PHP
            )
        );
    }
}
