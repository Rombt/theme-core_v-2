<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateNodeMaterializerInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateTreeRendererInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\Template;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\TemplatesInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIr;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\ValueObjects\TemplateIdentity;

final readonly class ClassicTemplateArtifactGenerator implements ArtifactGeneratorInterface
{
    private DiagnosticsService $diagnostics;

    public function __construct(
        private TemplateTreeRendererInterface $renderer,
        private TemplateNodeMaterializerInterface $nodeMaterializer,
        private ClassicTemplatePathResolver $pathResolver,
        Application $app,
    ) {
        $this->diagnostics = $app->getContext()->get(
            ApplicationContextKeys::DIAGNOSTICS,
        );
    }

    public function source(): string
    {
        return ThemeIr::class;
    }

    public function generate(
        object $source,
        ArtifactCollectionInterface $artifacts,
    ): void {
        if (!$source instanceof ThemeIr) {
            return;
        }

        foreach ($source->all() as $concept) {
            if (!$concept instanceof TemplatesInterface) {
                continue;
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
                        destination: $this->pathResolver->templateDestination(
                            $identity,
                        ),
                        content: $this->renderer->render($template),
                        metadata: [
                            'architecture' => 'classic',
                            'template' => $identity,
                            'role' => 'template',
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
    }

    /**
     * @param array<TemplateNode> $nodes
     */
    private function generateTemplatePartArtifacts(
        array $nodes,
        TemplateIdentity $templateIdentity,
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
        TemplateIdentity $templateIdentity,
        ArtifactCollectionInterface $artifacts,
    ): void {
        $resource = $node->resource();

        if ($resource === null) {
            return;
        }

        $type = $node->type()->value();

        if (!$this->isSupportedType($type)) {
            $this->diagnoseUnknownType(
                $node,
                $templateIdentity,
                $type,
            );

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
                destination: $this->pathResolver->templatePartDestination(
                    $type,
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
                    'template' => $templateIdentity->value(),
                    'resource' => $resourceId,
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

    private function isSupportedType(
        string $type,
    ): bool {
        return in_array(
            $type,
            [
                'layout',
                'post',
                'page',
                'product',
                'navigation',
                'form',
                'common',
            ],
            true,
        );
    }

    private function diagnoseUnknownType(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
        string $type,
    ): void {
        $metadata = [
            'template' => $templateIdentity,
            'node' => $node,
            'resource' => $node->resource()?->value(),
            'type' => $type,
            'rendering' => $node->rendering()->value,
            'architecture' => 'classic',
        ];

        $this->diagnostics->create(
            level: DiagnosticLevel::ERROR,
            message: sprintf(
                'Unknown template node type "%s".',
                $type,
            ),
            context: new DiagnosticContext($metadata),
            metadata: $metadata,
        );
    }
}
