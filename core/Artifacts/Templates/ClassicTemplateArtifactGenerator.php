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
use Rombt\ThemeCore\ThemeIR\Domains\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\TemplatesInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIR;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\ValueObjects\TemplateIdentity;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;

final readonly class ClassicTemplateArtifactGenerator implements ArtifactGeneratorInterface
{
    private DiagnosticsService $diagnostics;
    private LoggerInterface $logger;

    public function __construct(
        private TemplateTreeRendererInterface $renderer,
        private TemplateNodeMaterializerInterface $nodeMaterializer,
        private ClassicTemplatePathResolver $pathResolver,
        Application $app,
    ) {
        $context = $app->getContext();

        $this->diagnostics = $context->get(
            ApplicationContextKeys::DIAGNOSTICS,
        );

        $this->logger = $context->get(
            ApplicationContextKeys::LOGGER,
        );
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
                    true,
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
            && $node->resource() !== null;
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
