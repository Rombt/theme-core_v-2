<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateTreeRendererInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplatesInterface;

final readonly class ClassicTemplateArtifactGenerator implements ArtifactGeneratorInterface
{
    /**
     * @var array<string, string>
     */
    private const PART_DESTINATIONS = [
        'header' => 'header.php',
        'footer' => 'footer.php',
        'sidebar' => 'sidebar.php',
    ];

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

        foreach ($concept->templates() as $template) {
            $identity = $template->identity()->value();

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(
                        sprintf(
                            'template:classic:%s',
                            $identity,
                        ),
                    ),
                    type: ArtifactType::FILE,
                    destination: $this->destination($identity),
                    content: $this->renderer->render($template),
                    metadata: [
                        'architecture' => 'classic',
                        'template' => $identity,
                        'role' => $this->role($identity),
                    ],
                ),
            );
        }
    }

    private function destination(
        string $identity,
    ): string {
        return self::PART_DESTINATIONS[$identity]
            ?? sprintf('%s.php', $identity);
    }

    private function role(
        string $identity,
    ): string {
        return isset(self::PART_DESTINATIONS[$identity])
            ? 'template-part'
            : 'template';
    }
}
