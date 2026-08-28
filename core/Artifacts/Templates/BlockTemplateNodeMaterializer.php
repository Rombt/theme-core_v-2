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

final readonly class BlockTemplateNodeMaterializer implements TemplateNodeMaterializerInterface
{
    private string $resourcePackage;

    private DiagnosticsService $diagnostics;

    public function __construct(
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
    }

    public function materialize(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
        bool $isRoot = false,
    ): TemplateMaterializationResult {
        if ($this->isTemplatePartReference($node)) {
            return $this->materializeTemplatePartReference($node);
        }

        if ($node->resource() !== null) {
            return $this->materializeResourceNode(
                $node,
                $templateIdentity,
            );
        }

        return $this->materializeStructuralNode(
            $node,
            $templateIdentity,
        );
    }

    public function materializeTemplatePart(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        return $this->materializeResourceNode(
            $node,
            $templateIdentity,
        );
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
            $children[] = [
                'node' => $child,
                'result' => $this->materialize(
                    $child,
                    $templateIdentity,
                ),
            ];
        }

        return $children;
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

        return new TemplateMaterializationResult(
            $this->materializeSlots(
                $content,
                $children,
                $templateIdentity,
                $node,
            ),
        );
    }

    private function materializeStructuralNode(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult {
        $this->diagnose(
            DiagnosticLevel::ERROR,
            'Template node does not contain a resource.',
            [
                'template' => $templateIdentity,
                'node' => $node,
                'resource' => null,
            ],
        );

        $content = '';

        foreach ($node->children() as $child) {
            $content .= $this->materialize(
                $child,
                $templateIdentity,
            )->content();
        }

        return new TemplateMaterializationResult($content);
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

        return $this->removeUnresolvedSlots($content);
    }

    private function readResource(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): ?string {
        $resource = $node->resource();

        if ($resource === null) {
            return null;
        }

        $path = $this->resourcePath(
            $resource->value(),
            'block.html',
        );

        if (!is_file($path)) {
            $this->diagnose(
                DiagnosticLevel::ERROR,
                sprintf(
                    'Block template resource "%s" was not found.',
                    $path,
                ),
                [
                    'template' => $templateIdentity,
                    'node' => $node,
                    'resource' => $resource->value(),
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
                    'Unable to read Block template resource "%s".',
                    $path,
                ),
                [
                    'template' => $templateIdentity,
                    'node' => $node,
                    'resource' => $resource->value(),
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

    private function isTemplatePartReference(
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

    private function materializeTemplatePartReference(
        TemplateNode $node,
    ): TemplateMaterializationResult {
        $resource = $node->resource();

        if ($resource === null) {
            return new TemplateMaterializationResult('');
        }

        return new TemplateMaterializationResult(
            sprintf(
                '<!-- wp:template-part {"slug":"%s"} /-->',
                $this->normalizeSlug(
                    $resource->value(),
                ),
            ),
        );
    }

    private function normalizeSlug(
        string $value,
    ): string {
        return str_replace(
            '_',
            '-',
            trim($value),
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
