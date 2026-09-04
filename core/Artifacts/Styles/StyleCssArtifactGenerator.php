<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Styles;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Styles\Contracts\StyleCssContentRendererInterface;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

final readonly class StyleCssArtifactGenerator implements ArtifactGeneratorInterface
{
    public function __construct(
        private StyleCssContentRendererInterface $renderer,
        private StyleCssPathResolver $pathResolver,
        private ?Application $app,
    ) {
    }

    public function source(): string
    {
        return ThemeConfigurationPackage::class;
    }

    public function generate(object $source, ArtifactCollectionInterface $artifacts): void
    {

        if (!$source instanceof ThemeConfigurationPackage) {
            return;
        }

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('style:css'),
                type: ArtifactType::FILE,
                destination: $this->pathResolver->destination(),
                content: $this->renderer->render($source),
                metadata: [
                    'architecture' => 'shared',
                    'file' => 'style.css',
                    'role' => 'theme-style',
                ],
            ),
        );
    }
}
