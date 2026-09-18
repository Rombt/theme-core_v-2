<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Functions;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Functions\Contracts\FunctionsContentRendererInterface;
// use Rombt\ThemeCore\ThemeIR\Domains\Functions\FunctionsInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Functions\FunctionsInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

final readonly class BlockFunctionsArtifactGenerator implements ArtifactGeneratorInterface
{
    public function __construct(
        private FunctionsContentRendererInterface $renderer,
        private FunctionsPathResolver $pathResolver,
    ) {
    }

    public function source(): string
    {
        return ThemeIR::class;
    }

    public function generate(
        object $source,
        ArtifactCollectionInterface $artifacts,
    ): void {

        if (!$source instanceof ThemeIR) {
            return;
        }

        foreach ($source->all() as $concept) {
            if (!$concept instanceof FunctionsInterface) {
                continue;
            }

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId('functions:block'),
                    type: ArtifactType::FILE,
                    destination: $this->pathResolver->destination(),
                    content: $this->renderer->render($concept),
                    metadata: [
                    'architecture' => 'block',
                    'file' => 'functions.php',
                    'role' => 'theme-functions',
                    ],
                ),
            );
        }
    }
}
