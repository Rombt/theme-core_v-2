<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Theme\ThemeIr;
use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;
use Rombt\ThemeCore\Artifacts\Renderers\SiteTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\NavigationNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\QueryTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostLoopNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostContentNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\WidgetsNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\CopyrightNodeRenderer;

final class CompositionArtifactGenerator implements ArtifactGeneratorInterface
{
    /**
     * @var array<CompositionNodeRendererInterface>
     */
    private array $renderers;

    public function __construct()
    {
        $this->renderers = [
            new SiteTitleNodeRenderer(),
            new NavigationNodeRenderer(),
            new QueryTitleNodeRenderer(),
            new PostLoopNodeRenderer(),
            new PostTitleNodeRenderer(),
            new PostContentNodeRenderer(),
            new WidgetsNodeRenderer(),
            new CopyrightNodeRenderer(),
        ];
    }

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
        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($node)) {
                return $renderer->render($node);
            }
        }

        return sprintf('<!-- %s -->', $node);
    }
}
