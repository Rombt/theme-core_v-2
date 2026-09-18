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
use Rombt\ThemeCore\ThemeIR\Domains\Templates\Template;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\TemplatesInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIR;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\ValueObjects\TemplateIdentity;

final readonly class BlockTemplateArtifactGenerator implements ArtifactGeneratorInterface
{
    public function __construct(
        private TemplateTreeRendererInterface $renderer,
        private TemplateNodeMaterializerInterface $nodeMaterializer,
        private BlockTemplatePathResolver $pathResolver,
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
            if (!$concept instanceof TemplatesInterface) {
                continue;
            }

            foreach ($concept->templates() as $template) {
                $this->generateTemplateArtifact(
                    $template,
                    $artifacts,
                );

                $this->generateTemplatePartArtifacts(
                    $template->tree()->roots(),
                    $template->identity(),
                    $artifacts,
                    true,
                );
            }
        }
    }

    private function generateTemplateArtifact(
        Template $template,
        ArtifactCollectionInterface $artifacts,
    ): void {
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
                destination: $this->pathResolver->templateDestination(
                    $identity,
                ),
                content: $this->renderer->render($template),
                metadata: [
                    'architecture' => 'block',
                    'template' => $identity,
                    'role' => 'template',
                ],
            ),
        );
    }

    /**
     * @param array<int, TemplateNode> $nodes
     */
    private function generateTemplatePartArtifacts(
        array $nodes,
        TemplateIdentity $templateIdentity,
        ArtifactCollectionInterface $artifacts,
        bool $isRoot = false,
    ): void {
        foreach ($nodes as $node) {
            if (
                !$isRoot
                && $this->isGeneratedTemplatePart($node)
            ) {
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
        TemplateIdentity $templateIdentity,
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
                        'template-part:block:%s',
                        $resourceId,
                    ),
                ),
                type: ArtifactType::FILE,
                destination: $this->templatePartDestination(
                    $node,
                    $resourceId,
                ),
                content: $this->nodeMaterializer
                    ->materializeTemplatePart(
                        $node,
                        $templateIdentity,
                    )
                    ->content(),
                metadata: [
                    'architecture' => 'block',
                    'template' => $templateIdentity->value(),
                    'resource' => $resourceId,
                    'role' => 'template-part',
                ],
            ),
        );
    }

    private function templatePartDestination(
        TemplateNode $node,
        string $resourceId,
    ): string {
        return match ($node->rendering()->value) {
            'header' => $this->pathResolver->templatePartDestination(
                'header',
            ),

            'footer' => $this->pathResolver->templatePartDestination(
                'footer',
            ),

            default => $this->pathResolver->templatePartDestination(
                $resourceId,
            ),
        };
    }

    private function isGeneratedTemplatePart(
        TemplateNode $node,
    ): bool {
        return in_array(
            $node->rendering()->value,
            [
                'template-part',
                'header',
                'footer',
                'sidebar',
            ],
            true,
        ) && $node->resource() !== null;
    }
}
