<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Theme\ThemeIr;

final class WordPressThemeArtifactGenerator implements ArtifactGeneratorInterface
{
    public function generate(
        ThemeIr $ir,
        ArtifactCollectionInterface $artifacts
    ): void {
        $artifacts->add(
            new Artifact(
                id: new ArtifactId('style-css'),
                type: ArtifactType::FILE,
                destination: 'style.css',
                content: '/* Theme */'
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
