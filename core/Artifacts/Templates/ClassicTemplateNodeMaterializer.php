<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateNodeMaterializerInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\ValueObjects\TemplateIdentity;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;

final readonly class ClassicTemplateNodeMaterializer implements TemplateNodeMaterializerInterface
{
    private string $resourcePackage;

    private DiagnosticsService $diagnostics;
    private LoggerInterface $logger;

    public function __construct(
        private ClassicTemplatePathResolver $pathResolver,
        ?Application $app,
    ) {
        $context = $app->getContext();

        $configuration = $context->get(
            ApplicationContextKeys::CONFIGURATION,
        );

        $this->resourcePackage = $configuration->get(
            'theme.resource_package',
        );

        $this->diagnostics = $context->get(
            ApplicationContextKeys::DIAGNOSTICS,
        );

        $this->logger = $context->get(
            ApplicationContextKeys::LOGGER,
        );
    }

    public function materialize(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        return $this->materializeChild(
            $node,
            $templateIdentity,
        );
    }

    public function materializeTemplatePart(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        $resource = $node->resource();

        if ($resource === null) {
            return $this->materializationError(
                $node,
                $templateIdentity,
                'Template-part artifact requires a Resource.',
            );
        }

        $content = $this->readResource(
            $node,
            $templateIdentity,
        );

        if ($content === null) {
            return new TemplateMaterializationResult('');
        }

        $children = $this->materializeChildren(
            $node,
            $templateIdentity,
        );

        $content = $this->materializeSlots(
            $content,
            $children,
            $templateIdentity,
            $node,
        );

        return new TemplateMaterializationResult($content);
    }

    /**
     * Materializes a child according to the child's Rendering.
     *
     * The parent does not decide how the child is represented.
     */
    private function materializeChild(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        switch ($node->rendering()->value) {
            case 'inline':
                return $this->materializeResourceNode(
                    $node,
                    $templateIdentity,
                );

            case 'header':
                return new TemplateMaterializationResult(
                    '<?php get_header(); ?>',
                );

            case 'footer':
                return new TemplateMaterializationResult(
                    '<?php get_footer();' . "\n",
                );

            case 'sidebar':
                return new TemplateMaterializationResult(
                    '<?php get_sidebar(); ?>',
                );

            case 'template-part':
                return $this->materializeTemplatePartReference(
                    $node,
                    $templateIdentity,
                );

            default:
                return $this->materializationError(
                    $node,
                    $templateIdentity,
                    sprintf(
                        'Unsupported Classic rendering "%s".',
                        $node->rendering()->value,
                    ),
                );
        }
    }

    private function materializeResourceNode(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        $content = $this->readResource(
            $node,
            $templateIdentity,
        );

        if ($content === null) {
            return new TemplateMaterializationResult('');
        }

        $children = $this->materializeChildren(
            $node,
            $templateIdentity,
        );

        $content = $this->materializeSlots(
            $content,
            $children,
            $templateIdentity,
            $node,
        );

        return new TemplateMaterializationResult($content);
    }

    /**
     * @return array<int, array{
     *     node: TemplateNode,
     *     result: TemplateMaterializationResult
     * }>
     */
    private function materializeChildren(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): array {
        $children = [];

        foreach ($node->children() as $child) {
            $result = $this->materialize(
                $child,
                $templateIdentity,
            );

            $children[] = [
                'node' => $child,
                'result' => $result,
            ];
        }

        return $children;
    }

    /**
     * @param array<int, array{
     *     node: TemplateNode,
     *     result: TemplateMaterializationResult
     * }> $children
     */
    private function materializeSlots(
        string $content,
        array $children,
        TemplateIdentity $templateIdentity,
        TemplateNode $parent,
    ): string {
        foreach ($children as $childData) {
            /** @var TemplateNode $child */
            $child = $childData['node'];

            /** @var TemplateMaterializationResult $result */
            $result = $childData['result'];

            $slot = $child->slot();

            if ($slot === null) {
                $this->diagnose(
                    DiagnosticLevel::ERROR,
                    'Template child cannot be materialized because no slot is assigned.',
                    [
                        'template' => $templateIdentity,
                        'parent' => $parent,
                        'child' => $child,
                        'slot' => null,
                        'architecture' => 'classic',
                    ],
                );

                continue;
            }

            $placeholder = sprintf(
                '@slot_%d',
                $slot,
            );

            if (!str_contains($content, $placeholder)) {
                $this->diagnose(
                    DiagnosticLevel::ERROR,
                    sprintf(
                        'Template child references missing slot "%s".',
                        $placeholder,
                    ),
                    [
                        'template' => $templateIdentity,
                        'parent' => $parent,
                        'child' => $child,
                        'slot' => $slot,
                        'architecture' => 'classic',
                    ],
                );

                continue;
            }

            $content = str_replace(
                $placeholder,
                $result->content(),
                $content,
            );
        }

        $this->diagnoseUnusedSlots(
            $content,
            $templateIdentity,
            $parent,
        );

        return $this->removeUnresolvedSlots($content);
    }

    private function materializeTemplatePartReference(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        $resource = $node->resource();

        if ($resource === null) {
            return $this->materializationError(
                $node,
                $templateIdentity,
                'Template-part reference requires a Resource.',
            );
        }

        $type = $node->type()->value();

        try {
            $slug = $this->pathResolver->templatePartSlug(
                $type,
                $resource->value(),
            );
        } catch (\InvalidArgumentException $exception) {
            return $this->materializationError(
                $node,
                $templateIdentity,
                $exception->getMessage(),
            );
        }

        return new TemplateMaterializationResult(
            sprintf(
                '<?php get_template_part(%s); ?>',
                var_export(
                    $slug,
                    true,
                ),
            ),
        );
    }

    private function readResource(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): ?string {
        $resource = $node->resource();

        if ($resource === null) {
            $this->diagnose(
                DiagnosticLevel::ERROR,
                'Template node does not contain a Resource.',
                [
                    'template' => $templateIdentity,
                    'node' => $node,
                    'resource' => null,
                    'architecture' => 'classic',
                ],
            );

            return null;
        }

        $path = $this->resourcePath(
            $resource->value(),
            'classic.php',
        );

        if (!is_file($path)) {
            $this->diagnose(
                DiagnosticLevel::ERROR,
                sprintf(
                    'Classic template Resource "%s" was not found.',
                    $path,
                ),
                [
                    'template' => $templateIdentity,
                    'node' => $node,
                    'resource' => $resource->value(),
                    'architecture' => 'classic',
                    'path' => $path,
                ],
            );

            return null;
        }

        $content = file_get_contents($path);

        if ($content === false) {
            $this->diagnose(
                DiagnosticLevel::ERROR,
                sprintf(
                    'Unable to read Classic template Resource "%s".',
                    $path,
                ),
                [
                    'template' => $templateIdentity,
                    'node' => $node,
                    'resource' => $resource->value(),
                    'architecture' => 'classic',
                    'path' => $path,
                ],
            );

            return null;
        }

        return $content;
    }

    private function resourcePath(
        string $resourceId,
        string $filename,
    ): string {
        return rtrim(
            $this->resourcePackage,
            '/\\',
        )
            . DIRECTORY_SEPARATOR
            . 'components'
            . DIRECTORY_SEPARATOR
            . $resourceId
            . DIRECTORY_SEPARATOR
            . $filename;
    }

    private function removeUnresolvedSlots(
        string $content,
    ): string {
        return preg_replace(
            '/@slot_\d+/',
            '',
            $content,
        ) ?? $content;
    }

    private function materializationError(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
        string $message,
    ): TemplateMaterializationResult {
        $this->diagnose(
            DiagnosticLevel::ERROR,
            $message,
            [
                'template' => $templateIdentity,
                'node' => $node,
                'resource' => $node->resource()?->value(),
                'rendering' => $node->rendering()->value,
                'architecture' => 'classic',
            ],
        );

        return new TemplateMaterializationResult('');
    }

    private function diagnoseUnusedSlots(
        string $content,
        TemplateIdentity $templateIdentity,
        TemplateNode $parent,
    ): void {
        if (
            preg_match_all(
                '/@slot_(\d+)/',
                $content,
                $matches,
            ) === false
        ) {
            return;
        }

        foreach ($matches[1] as $slot) {
            $this->diagnose(
                DiagnosticLevel::ERROR,
                sprintf(
                    'Template resource contains unused slot "@slot_%s".',
                    $slot,
                ),
                [
                    'template' => $templateIdentity,
                    'parent' => $parent,
                    'slot' => (int) $slot,
                    'architecture' => 'classic',
                ],
            );
        }
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function diagnose(
        DiagnosticLevel $level,
        string $message,
        array $metadata = [],
    ): void {
        $context = new DiagnosticContext($metadata);

        $this->diagnostics->create(
            level: $level,
            message: $message,
            context: $context,
            metadata: $metadata,
        );
    }
}
