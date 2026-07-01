<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Theme\ThemeIr;

final class CompositionArtifactGenerator implements ArtifactGeneratorInterface
{
    public function generate(
        ThemeIr $ir,
        ArtifactCollectionInterface $artifacts,
    ): void {
        $compositions = $ir->compositions();

        foreach ($compositions as $id => $composition) {
            $type = $composition['type'] ?? 'template';

            $destination = $type === 'template-part'
                ? sprintf('parts/%s.html', $id)
                : sprintf('templates/%s.html', $id);

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(sprintf('composition-%s', $id)),
                    type: ArtifactType::FILE,
                    destination: $destination,
                    content: $this->render($composition, $compositions),
                )
            );
        }
    }

    /**
     * @param array<string, mixed> $composition
     * @param array<string, array<string, mixed>> $compositions
     */
    private function render(
        array $composition,
        array $compositions,
    ): string {
        return $this->renderChildren(
            $composition['children'] ?? [],
            $compositions,
        );
    }

    /**
     * @param array<int, mixed> $children
     * @param array<string, array<string, mixed>> $compositions
     */
    private function renderChildren(
        array $children,
        array $compositions,
    ): string {
        $lines = [];

        foreach ($children as $child) {
            if (is_string($child)) {
                if (
                    isset($compositions[$child])
                    && ($compositions[$child]['type'] ?? null) === 'template-part'
                ) {
                    $lines[] = sprintf(
                        '<!-- wp:template-part {"slug":"%s"} /-->',
                        $child
                    );

                    continue;
                }

                $lines[] = $this->renderNode($child);

                continue;
            }

            if (is_array($child)) {
                $id = $child['id'] ?? 'composition';

                $lines[] = sprintf('<!-- %s:start -->', $id);

                $content = $this->renderChildren(
                    $child['children'] ?? [],
                    $compositions,
                );

                if ($content !== '') {
                    $lines[] = $content;
                }

                $lines[] = sprintf('<!-- %s:end -->', $id);
            }
        }

        return implode(PHP_EOL . PHP_EOL, $lines);
    }

    private function renderNode(string $node): string
    {
        return match ($node) {
            'site-title' => <<<'HTML'
                <!-- wp:site-title /-->
                HTML,

            'navigation' => <<<'HTML'
                <!-- wp:navigation /-->
                HTML,

            'page-title',
            'archive-title' => <<<'HTML'
                <!-- wp:query-title /-->
                HTML,

            'post-title' => <<<'HTML'
                <!-- wp:post-title /-->
                HTML,

            'post-content' => <<<'HTML'
                <!-- wp:post-content /-->
                HTML,

            'post-loop' => <<<'HTML'
                <!-- wp:query -->
                <div class="wp-block-query">
                    <!-- wp:post-template -->
                        <!-- wp:post-title {"isLink":true} /-->
                        <!-- wp:post-excerpt /-->
                    <!-- /wp:post-template -->
                </div>
                <!-- /wp:query -->
                HTML,

            'widgets' => <<<'HTML'
                <!-- wp:template-part {"slug":"sidebar"} /-->
                HTML,

            'copyright' => <<<'HTML'
                <!-- wp:paragraph -->
                <p>© Copyright</p>
                <!-- /wp:paragraph -->
                HTML,

            default => sprintf('<!-- %s -->', $node),
        };
    }
}
