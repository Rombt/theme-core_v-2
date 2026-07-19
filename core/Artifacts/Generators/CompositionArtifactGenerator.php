<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;
use Rombt\ThemeCore\Artifacts\Renderers\CopyrightNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\NavigationNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostContentNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostLoopNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\QueryTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\SiteTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\WidgetsNodeRenderer;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Compositions\CompositionIr;

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

    public function supports(): string
    {
        return CompositionIr::class;
    }

    public function generate(
        ThemeIrInterface $ir,
        ArtifactCollectionInterface $artifacts,
    ): void {
        /** @var CompositionIr $ir */

        $compositions = $ir->configuration();

        foreach ($compositions->compositions() as $id => $composition) {
            $destination = $composition['type'] === 'template-part'
                ? sprintf('parts/%s.html', $id)
                : sprintf('templates/%s.html', $id);

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(sprintf('composition-%s', $id)),
                    type: ArtifactType::FILE,
                    destination: $destination,
                    content: $this->render($composition, $compositions),
                ),
            );
        }
    }

    private function render(
        array $composition,
        CompositionsConfiguration $compositions,
    ): string {
        return $this->renderChildren(
            $composition['children'] ?? [],
            $compositions,
        );
    }

    private function renderChildren(
        array $children,
        CompositionsConfiguration $compositions,
    ): string {
        $lines = [];

        foreach ($children as $child) {
            if (is_string($child)) {
                $composition = $this->findComposition($child, $compositions);

                if (
                    $composition !== null
                    && $composition['type'] === 'template-part'
                ) {
                    $lines[] = sprintf(
                        '<!-- wp:template-part {"slug":"%s"} /-->',
                        $child,
                    );

                    continue;
                }

                $lines[] = $this->renderNode($child);

                continue;
            }

            if (is_array($child)) {
                $lines[] = sprintf(
                    '<!-- %s:start -->',
                    $child['id'],
                );

                $content = $this->renderChildren(
                    $child['children'] ?? [],
                    $compositions,
                );

                if ($content !== '') {
                    $lines[] = $content;
                }

                $lines[] = sprintf(
                    '<!-- %s:end -->',
                    $child['id'],
                );
            }
        }

        return implode(PHP_EOL . PHP_EOL, $lines);
    }

    private function findComposition(
        string $id,
        CompositionsConfiguration $compositions,
    ): ?array {
        return $compositions->compositions()[$id] ?? null;
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
