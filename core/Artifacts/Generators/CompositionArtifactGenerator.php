<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIr;
use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;
use Rombt\ThemeCore\Artifacts\Renderers\SiteTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\NavigationNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\QueryTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostLoopNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostTitleNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\PostContentNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\WidgetsNodeRenderer;
use Rombt\ThemeCore\Artifacts\Renderers\CopyrightNodeRenderer;
use Rombt\ThemeCore\Resolution\Domains\Compositions\CompositionIr;
use Rombt\ThemeCore\Resolution\Domains\Compositions\Composition;
use Rombt\ThemeCore\Resolution\Domains\Compositions\CompositionCollection;
use Rombt\ThemeCore\Resolution\Domains\Compositions\CompositionChild;

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
        $domain = $ir->domain('compositions');

        if (!$domain instanceof CompositionIr) {
            return;
        }

        $compositions = $domain->compositions();

        foreach ($compositions->all() as $composition) {
            $destination = $composition->type() === 'template-part'
                ? sprintf('parts/%s.html', $composition->id())
                : sprintf('templates/%s.html', $composition->id());

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(sprintf('composition-%s', $composition->id())),
                    type: ArtifactType::FILE,
                    destination: $destination,
                    content: $this->render($composition, $compositions),
                )
            );
        }
    }

    private function render(
        Composition $composition,
        CompositionCollection $compositions,
    ): string {
        return $this->renderChildren(
            $composition->children(),
            $compositions,
        );
    }

    /**
     * @param array<CompositionChild|string> $children
     */
    private function renderChildren(
        array $children,
        CompositionCollection $compositions,
    ): string {
        $lines = [];

        foreach ($children as $child) {
            if (is_string($child)) {
                $composition = $compositions->get($child);

                if (
                    $composition !== null
                    && $composition->type() === 'template-part'
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
            if ($child instanceof CompositionChild) {
                $lines[] = sprintf(
                    '<!-- %s:start -->',
                    $child->id(),
                );

                $content = $this->renderChildren(
                    $child->children(),
                    $compositions,
                );

                if ($content !== '') {
                    $lines[] = $content;
                }

                $lines[] = sprintf(
                    '<!-- %s:end -->',
                    $child->id(),
                );
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
