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

final readonly class BlockTemplateArtifactGenerator implements ArtifactGeneratorInterface
{
    /**
     * @var array<string, string>
     */
    private const PART_DESTINATIONS = [
        'header' => 'parts/header.html',
        'footer' => 'parts/footer.html',
        'sidebar' => 'parts/sidebar.html',
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
                            'template:block:%s',
                            $identity,
                        ),
                    ),
                    type: ArtifactType::FILE,
                    destination: $this->destination($identity),
                    content: $this->renderer->render($template),
                    metadata: [
                        'architecture' => 'block',
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
            ?? sprintf('templates/%s.html', $identity);
    }

    private function role(
        string $identity,
    ): string {
        return isset(self::PART_DESTINATIONS[$identity])
            ? 'template-part'
            : 'template';
    }
}
