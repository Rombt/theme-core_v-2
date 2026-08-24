<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateNodeMaterializerInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity;

final readonly class ClassicTemplateNodeMaterializer implements TemplateNodeMaterializerInterface
{
    private string $resourcePackage;

    private DiagnosticsService $diagnostics;

    public function __construct(
        ?Application $app,
    ) {
        $context = $app->getContext();

        $configuration = $context->get(
            ApplicationContextKeys::CONFIGURATION
        );

        $this->resourcePackage = $configuration->get(
            'theme.resource_package'
        );

        $this->diagnostics = $context->get(
            ApplicationContextKeys::DIAGNOSTICS
        );
    }

    public function materialize(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
        bool $isRoot = false,
    ): TemplateMaterializationResult {
        return match ($this->determineNodeStrategy($node)) {
            'template-part' => $this->materializeTemplatePartNode(
                $node,
                $templateIdentity,
            ),

            'resource' => $this->materializeResourceNode(
                $node,
                $templateIdentity,
            ),

            'structural' => $this->materializeStructuralNode(
                $node,
                $templateIdentity,
            ),
        };
    }

    private function determineNodeStrategy(
        TemplateNode $node,
    ): string {
        if ($this->isTemplatePartNode($node)) {
            return 'template-part';
        }

        if ($node->resource() !== null) {
            return 'resource';
        }

        return 'structural';
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

            if ($result->content() === '') {
                continue;
            }

            $children[] = [
                'node' => $child,
                'result' => $result,
            ];
        }

        return $children;
    }

    private function materializeStructuralNode(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        $this->diagnose(
            DiagnosticLevel::ERROR,
            'Template node does not contain a resource.',
            new DiagnosticContext([
                'template' => $templateIdentity,
                'node' => $node,
            ]),
            [
                'template' => $templateIdentity,
                'node' => $node,
                'resource' => null,
            ],
        );

        return new TemplateMaterializationResult('');
    }

    private function materializeResourceNode(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        $children = $this->materializeChildren(
            $node,
            $templateIdentity,
        );

        $resource = $node->resource();

        if ($resource === null) {
            return $this->materializeStructuralNode(
                $node,
                $templateIdentity,
            );
        }

        $content = $this->readResource(
            $resource->value(),
            $templateIdentity,
            $node,
        );

        if ($content === null) {
            return new TemplateMaterializationResult('');
        }

        return $this->materializeSlots(
            $content,
            $children,
            $templateIdentity,
            $node,
        );
    }

    private function materializeTemplatePartNode(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        /*
         * Header, footer, sidebar and template-part are not inlined.
         *
         * Their own materialization is handled when their corresponding
         * Artifact is generated.
         */
        if ($node->resource() === null) {
            return $this->materializeStructuralNode(
                $node,
                $templateIdentity,
            );
        }

        return new TemplateMaterializationResult(
            $this->templatePartCall($node),
        );
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
    ): TemplateMaterializationResult {
        $slottedChildren = [];

        foreach ($children as $childData) {
            /** @var TemplateNode $child */
            $child = $childData['node'];

            /** @var TemplateMaterializationResult $result */
            $result = $childData['result'];

            $slot = $child->slot();

            if ($slot === null) {
                $this->diagnose(
                    DiagnosticLevel::ERROR,
                    'Template child does not have a required slot.',
                    new DiagnosticContext([
                        'template' => $templateIdentity,
                        'parent' => $parent,
                        'child' => $child,
                    ]),
                    [
                        'template' => $templateIdentity,
                        'parent' => $parent,
                        'child' => $child,
                        'slot' => null,
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
                    new DiagnosticContext([
                        'template' => $templateIdentity,
                        'parent' => $parent,
                        'child' => $child,
                    ]),
                    [
                        'template' => $templateIdentity,
                        'parent' => $parent,
                        'child' => $child,
                        'slot' => $slot,
                    ],
                );

                continue;
            }

            $slottedChildren[$slot] = $result->content();
        }

        foreach ($slottedChildren as $slot => $childContent) {
            $content = str_replace(
                sprintf('@slot_%d', $slot),
                $childContent,
                $content,
            );
        }

        $content = $this->removeUnresolvedSlots(
            $content,
        );

        return new TemplateMaterializationResult(
            $content,
            $slottedChildren,
        );
    }

    private function readResource(
        string $resourceId,
        TemplateIdentity $templateIdentity,
        TemplateNode $node,
    ): ?string {
        $path = rtrim(
            $this->resourcePackage,
            '/\\',
        )
            . DIRECTORY_SEPARATOR
            . 'components'
            . DIRECTORY_SEPARATOR
            . $resourceId
            . DIRECTORY_SEPARATOR
            . 'classic.php';

        if (!is_file($path)) {
            $this->diagnose(
                DiagnosticLevel::ERROR,
                sprintf(
                    'Classic template resource "%s" was not found.',
                    $path,
                ),
                new DiagnosticContext([
                    'template' => $templateIdentity,
                    'node' => $node,
                ]),
                [
                    'template' => $templateIdentity,
                    'node' => $node,
                    'resource' => $resourceId,
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
                    'Unable to read Classic template resource "%s".',
                    $path,
                ),
                new DiagnosticContext([
                    'template' => $templateIdentity,
                    'node' => $node,
                ]),
                [
                    'template' => $templateIdentity,
                    'node' => $node,
                    'resource' => $resourceId,
                    'path' => $path,
                ],
            );

            return null;
        }

        return $content;
    }

    private function templatePartCall(
        TemplateNode $node,
    ): string {
        return match ($node->rendering()->value) {
            'header' => '<?php get_header(); ?>',
            'footer' => '<?php get_footer(); ?>',
            'sidebar' => '<?php get_sidebar(); ?>',
            'template-part' => $this->templatePartInclude($node),
            default => '',
        };
    }

    private function templatePartInclude(
        TemplateNode $node,
    ): string {
        $resource = $node->resource();

        if ($resource === null) {
            return '';
        }

        return sprintf(
            '<?php get_template_part(%s); ?>',
            var_export(
                $resource->value(),
                true,
            ),
        );
    }

    private function isTemplatePartNode(
        TemplateNode $node,
    ): bool {
        return in_array(
            $node->rendering()->value,
            [
                'header',
                'footer',
                'sidebar',
                'template-part',
            ],
            true,
        );
    }

    private function diagnose(
        DiagnosticLevel $level,
        string $message,
        DiagnosticContext $context,
        array $metadata = [],
    ): void {
        $this->diagnostics->create(
            level: $level,
            message: $message,
            context: $context,
            metadata: $metadata,
        );
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
}
