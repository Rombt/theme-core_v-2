<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Functions;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Functions\Contracts\FunctionsContentRendererInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Functions\FunctionsInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

final readonly class ClassicFunctionsArtifactGenerator implements ArtifactGeneratorInterface
{
    public function __construct(
        private FunctionsContentRendererInterface $renderer,
        private FunctionsPathResolver $pathResolver,
        private Application $app,
    ) {
    }

    public function source(): string
    {
        return ThemeIR::class;
    }

    public function generate(object $source, ArtifactCollectionInterface $artifacts): void
    {


        $logger = $this->app->getContext()->get(ApplicationContextKeys::LOGGER);
        // $logger->dump('ClassicFunctionsArtifactGenerator    $source = ');


        if (!$source instanceof ThemeIR) {
            return;
        }

        foreach ($source->all() as $concept) {
            if (!$concept instanceof FunctionsInterface) {
                continue;
            }


            $artifacts->add(
                new Artifact(
                    id: new ArtifactId('functions:classic'),
                    type: ArtifactType::FILE,
                    destination: $this->pathResolver->destination(),
                    content: $this->renderer->render($concept),
                    metadata: [
                    'architecture' => 'classic',
                    'file' => 'functions.php',
                    'role' => 'theme-functions',
                    ],
                ),
            );
        }

        // $logger->dump('ClassicFunctionsArtifactGenerator    $artifacts = ');
        // $logger->dump($artifacts);
    }
}
