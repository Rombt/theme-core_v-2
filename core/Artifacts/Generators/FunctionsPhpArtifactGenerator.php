<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Contracts\AssetRegistrationRendererInterface;
use Rombt\ThemeCore\Theme\ThemeIr;
use Rombt\ThemeCore\WordPress\Assets\AssetRegistrationBuilder;

final readonly class FunctionsPhpArtifactGenerator implements ArtifactGeneratorInterface
{
    public function __construct(
        private AssetRegistrationBuilder $builder,
        private AssetRegistrationRendererInterface $renderer,
    ) {
    }

    public function generate(
        ThemeIr $ir,
        ArtifactCollectionInterface $artifacts,
    ): void {
        $registrations = $this->builder->build(
            $ir->assets(),
        );

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('functions-php'),
                type: ArtifactType::FILE,
                destination: 'functions.php',
                content: $this->renderer->render(
                    $registrations,
                ),
            ),
        );
    }
}
