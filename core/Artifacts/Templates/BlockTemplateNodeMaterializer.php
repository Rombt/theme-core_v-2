<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use RuntimeException;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateNodeMaterializerInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;

final readonly class BlockTemplateNodeMaterializer implements TemplateNodeMaterializerInterface
{
    public function __construct(
        private string $resourcePackage,
    ) {
    }

    public function materialize(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
        bool $isRoot = false,
    ): TemplateMaterializationResult {
        $slottedChildren = [];
        $unslottedChildren = [];

        foreach ($node->children() as $child) {
            $result = $this->materialize(
                $child,
                $templateIdentity,
            );

            if ($child->slot() === null) {
                $unslottedChildren[] = $result->content();

                continue;
            }

            $slottedChildren[$child->slot()] = $result->content();
        }

        $resource = $node->resource();

        if ($resource === null) {
            return new TemplateMaterializationResult(
                $this->joinChildren(
                    $unslottedChildren,
                    $slottedChildren,
                ),
                $slottedChildren,
            );
        }

        $path = rtrim($this->resourcePackage, '/\\')
            . DIRECTORY_SEPARATOR
            . 'components'
            . DIRECTORY_SEPARATOR
            . $resource->value()
            . DIRECTORY_SEPARATOR
            . 'block.html';

        if (!is_file($path)) {
            throw new RuntimeException(
                sprintf(
                    'Block template resource "%s" was not found.',
                    $path,
                ),
            );
        }

        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException(
                sprintf(
                    'Unable to read Block template resource "%s".',
                    $path,
                ),
            );
        }

        foreach ($slottedChildren as $slot => $childContent) {
            $content = str_replace(
                sprintf('@slot_%d', $slot),
                $childContent,
                $content,
            );
        }

        $content = $this->removeUnresolvedSlots($content);

        $unslottedContent = $this->joinContents(
            $unslottedChildren,
        );

        if ($unslottedContent !== '') {
            $content .= PHP_EOL . $unslottedContent;
        }

        return new TemplateMaterializationResult(
            $content,
            $slottedChildren,
        );
    }

    /**
     * @param array<int, string> $unslottedChildren
     * @param array<int, string> $slottedChildren
     */
    private function joinChildren(
        array $unslottedChildren,
        array $slottedChildren,
    ): string {
        ksort($slottedChildren);

        return $this->joinContents([
            ...$unslottedChildren,
            ...array_values($slottedChildren),
        ]);
    }

    /**
     * @param array<int, string> $contents
     */
    private function joinContents(
        array $contents,
    ): string {
        $contents = array_values(
            array_filter(
                $contents,
                static fn (string $content): bool => $content !== '',
            ),
        );

        return implode(PHP_EOL, $contents);
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
