<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactCollection;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplatesInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;

final readonly class ClassicTemplateArtifactGenerator implements ArtifactGeneratorInterface
{
    public function __construct(
        private TemplateTreeRendererInterface $renderer,
    ) {
    }

    public function supports(): string
    {
        return TemplatesInterface::class;
    }

    public function generate(
        object $concept,
        ArtifactCollectionInterface $artifacts,
    ): void {
        if (!$concept instanceof TemplatesInterface) {
            return;
        }

        foreach ($concept->templates()->all() as $template) {
            $artifacts->add(
                $this->createArtifact($template),
            );
        }
    }

    private function createArtifact(Template $template): Artifact
    {

        return new Artifact(
            id: new ArtifactId(
                'template:classic:' . $template->identity()->value(),
            ),
            type: ArtifactType::FILE,
            destination: $template->identity()->value() . '.php',
            content: $this->renderer->render(
                $template->tree(),
            ),
        );
    }
}
