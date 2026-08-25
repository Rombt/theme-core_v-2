<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateNodeMaterializerInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateTreeRendererInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;
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
        private TemplateNodeMaterializerInterface $nodeMaterializer,
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

            $this->generateTemplatePartArtifacts(
                $template->tree()->roots(),
                $template->identity(),
                $artifacts,
            );
        }
    }

    /**
     * @param array<TemplateNode> $nodes
     */
    private function generateTemplatePartArtifacts(
        array $nodes,
        \Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity $templateIdentity,
        ArtifactCollectionInterface $artifacts,
    ): void {
        foreach ($nodes as $node) {
            if ($this->isGeneratedTemplatePart($node)) {
                $this->generateTemplatePartArtifact(
                    $node,
                    $templateIdentity,
                    $artifacts,
                );
            }

            $this->generateTemplatePartArtifacts(
                $node->children(),
                $templateIdentity,
                $artifacts,
            );
        }
    }

    private function generateTemplatePartArtifact(
        TemplateNode $node,
        \Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity $templateIdentity,
        ArtifactCollectionInterface $artifacts,
    ): void {
        $resource = $node->resource();

        if ($resource === null) {
            return;
        }

        $resourceId = $resource->value();

        $artifacts->add(
            new Artifact(
                id: new ArtifactId(
                    sprintf(
                        'template-part:classic:%s',
                        $resourceId,
                    ),
                ),
                type: ArtifactType::FILE,
                destination: sprintf(
                    '%s.php',
                    $resourceId,
                ),
                content: $this->nodeMaterializer
                    ->materializeTemplatePart(
                        $node,
                        $templateIdentity,
                    )
                    ->content(),
                metadata: [
                    'architecture' => 'classic',
                    'template' => $resourceId,
                    'role' => 'template-part',
                ],
            ),
        );
    }

    private function isGeneratedTemplatePart(
        TemplateNode $node,
    ): bool {
        return $node->rendering()->value === 'template-part'
            && $node->resource() !== null
            && !$this->isStructuralTemplatePart($node);
    }

    private function isStructuralTemplatePart(
        TemplateNode $node,
    ): bool {
        return in_array(
            $node->rendering()->value,
            [
                'header',
                'footer',
                'sidebar',
            ],
            true,
        );
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
