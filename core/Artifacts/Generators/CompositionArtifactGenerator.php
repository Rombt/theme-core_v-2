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
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Composition;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionNodeCollection;

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

        $compositions = $ir->compositions();

        foreach ($compositions as $composition) {
            $destination = $composition->isTemplatePart()
                ? sprintf('parts/%s.html', $composition->id())
                : sprintf('templates/%s.html', $composition->id());

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(sprintf('composition-%s', $composition->id())),
                    type: ArtifactType::FILE,
                    destination: $destination,
                    content: $this->render($composition, $compositions),
                ),
            );
        }
    }

    private function render(
        Composition $composition,
        CompositionCollection $compositions,
    ): string {
        return $this->renderChildren(
            $composition->nodes(),
            $compositions,
        );
    }

    private function renderChildren(
        CompositionNodeCollection $nodes,
        CompositionCollection $compositions,
    ): string {
        $lines = [];

        foreach ($nodes as $node) {
            $composition = $this->findComposition(
                $node->id(),
                $compositions,
            );

            if (
                $composition !== null
                && $composition->isTemplatePart()
            ) {
                $lines[] = sprintf(
                    '<!-- wp:template-part {"slug":"%s"} /-->',
                    $node->id(),
                );

                continue;
            }

            if ($node->children()->isEmpty()) {
                $lines[] = $this->renderNode(
                    $node->id(),
                );

                continue;
            }

            $lines[] = sprintf(
                '<!-- %s:start -->',
                $node->id(),
            );

            $content = $this->renderChildren(
                $node->children(),
                $compositions,
            );

            if ($content !== '') {
                $lines[] = $content;
            }

            $lines[] = sprintf(
                '<!-- %s:end -->',
                $node->id(),
            );
        }

        return implode(PHP_EOL . PHP_EOL, $lines);
    }

    private function findComposition(
        string $id,
        CompositionCollection $compositions,
    ): ?Composition {
        return $compositions->find($id);
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
