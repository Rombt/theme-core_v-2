<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use LogicException;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplatesInterface;

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
            throw new LogicException(
                'Expected Templates concept.',
            );
        }

        foreach ($concept->templates() as $template) {
            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(
                        sprintf(
                            'template:%s',
                            $template->identity()->value(),
                        ),
                    ),
                    type: ArtifactType::FILE,
                    destination: $this->destination($template),
                    content: $this->content($template),
                ),
            );
        }
    }

    private function destination(Template $template): string
    {
        return sprintf(
            '%s.php',
            $template->identity()->value(),
        );
    }

    private function content(Template $template): string
    {
        return $this->renderer->render(
            $template->tree(),
        );
    }
}
