<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Templates;
use Rombt\ThemeCore\ThemeIr\Contracts\ThemeConceptInterface;

final readonly class ClassicPhpArtifactGenerator implements ArtifactGeneratorInterface
{
    public function __construct(
        private ClassicPhpTemplateRenderer $renderer,
    ) {
    }

    public function supports(): string
    {
        return Templates::class;
    }

    public function generate(
        ThemeConceptInterface $ir,
        ArtifactCollectionInterface $artifacts,
    ): void {
        /** @var Templates $ir */

        foreach ($ir->templates() as $template) {
            $artifacts->add(
                $this->createArtifact($template),
            );
        }
    }

    private function createArtifact(
        Template $template,
    ): Artifact {
        return new Artifact(
            id: new ArtifactId(
                (string) $template->identity(),
            ),
            type: ArtifactType::FILE,
            destination: $this->destination($template),
            content: $this->renderer->render($template),
        );
    }

    private function destination(
        Template $template,
    ): string {
        return sprintf(
            '%s.php',
            $template->identity()->value(),
        );
    }
}
