<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Domains\Templates;

use LogicException;
use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Composition;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodesComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ResolvedResource;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Node;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateCollection;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateTreeBuilder;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Templates;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity;
use Rombt\ThemeCore\ThemeIr\Contracts\ThemeConceptInterface;
use Rombt\ThemeCore\ThemeIr\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;

final readonly class TemplatesThemeIrResolver implements ThemeIrResolverInterface
{
    public function __construct(
        private TemplateTreeBuilder $treeBuilder = new TemplateTreeBuilder(),
    ) {
    }

    public function resolve(
        ThemeComponentCollection $components,
    ): ThemeConceptInterface {
        $compositionsThemeComponent = $components->find(
            new ComponentId('compositions'),
        );

        if ($compositionsThemeComponent === null) {
            throw new RuntimeException(
                'Theme component "compositions" not found.',
            );
        }

        $nodesThemeComponent = $components->find(
            new ComponentId('nodes'),
        );

        if ($nodesThemeComponent === null) {
            throw new RuntimeException(
                'Theme component "nodes" not found.',
            );
        }

        $compositionsComponent = $compositionsThemeComponent->component();

        if (!$compositionsComponent instanceof CompositionsComponent) {
            throw new RuntimeException(
                'Theme component "compositions" must contain CompositionsComponent.',
            );
        }

        $nodesComponent = $nodesThemeComponent->component();

        if (!$nodesComponent instanceof NodesComponent) {
            throw new RuntimeException(
                'Theme component "nodes" must contain NodesComponent.',
            );
        }

        $resources = [];

        foreach ($nodesComponent->resources() as $resource) {
            $resources[$resource->resource()->id()] = $resource;
        }

        $templates = [];

        foreach ($compositionsComponent->compositions() as $composition) {
            if ($composition->isTemplatePart()) {
                continue;
            }

            $templates[] = $this->createTemplate(
                $composition,
                function (Node $node) use ($resources): ResolvedResource {
                    $resourceId = $node->resource() !== ''
                        ? $node->resource()
                        : $node->id();

                    if (!isset($resources[$resourceId])) {
                        throw new LogicException(sprintf(
                            'Resolved resource "%s" not found.',
                            $resourceId,
                        ));
                    }

                    return $resources[$resourceId];
                },
            );
        }

        return new Templates(
            id: new IrId('templates'),
            templates: new TemplateCollection($templates),
        );
    }

    /**
     * @param callable(Node): ResolvedResource $nodeResolver
     */
    private function createTemplate(
        Composition $composition,
        callable $nodeResolver,
    ): Template {
        return new Template(
            identity: new TemplateIdentity($composition->id()),
            tree: $this->treeBuilder->build(
                $composition->nodes(),
                $nodeResolver,
            ),
        );
    }
}
