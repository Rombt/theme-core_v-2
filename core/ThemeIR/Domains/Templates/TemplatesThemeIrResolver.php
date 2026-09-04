<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Templates;

use LogicException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodesComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\NodeFunctionDefinitionCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\Template;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\TemplateCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\TemplateTreeBuilder;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\Templates;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\ValueObjects\TemplateIdentity;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\FunctionDefinition;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Resource;
use Rombt\ThemeCore\ThemeIR\IrId;

final readonly class TemplatesThemeIrResolver implements ThemeIrResolverInterface
{
    public function supports(
        ThemeComponentInterface $component,
    ): bool {
        return $component instanceof CompositionsComponent;
    }

    public function resolve(ThemeComponentCollection $components): Templates
    {

        $compositionsComponent = $this->getComponent(
            $components,
            'compositions',
            CompositionsComponent::class,
        );

        $nodesComponent = $this->getComponent(
            $components,
            'nodes',
            NodesComponent::class,
        );

        $functionDefinitions = [];

        foreach ($nodesComponent->nodes() as $node) {
            $function = $node->function();


            if ($function === null) {
                continue;
            }

            $functionDefinitions[$node->id()] = new FunctionDefinition(
                enabled: $function->enabled(),
                resource: new Resource($node->resource()),
                order: $function->order(),
            );
        }

        $treeBuilder = new TemplateTreeBuilder(
            nodes: $nodesComponent->nodes(),
            compositions: $compositionsComponent->compositions(),
            functionDefinitions: new NodeFunctionDefinitionCollection(
                $functionDefinitions,
            ),
        );

        $templates = [];

        foreach ($compositionsComponent->compositions() as $composition) {
            $templates[] = new Template(
                identity: new TemplateIdentity(
                    $composition->id(),
                ),
                tree: $treeBuilder->build($composition),
            );
        }

        return new Templates(
            id: new IrId('templates'),
            templates: new TemplateCollection($templates),
        );
    }

    /**
     * @template T of ThemeComponentInterface
     *
     * @param class-string<T> $expectedClass
     *
     * @return T
     */
    private function getComponent(
        ThemeComponentCollection $components,
        string $id,
        string $expectedClass,
    ): ThemeComponentInterface {
        $component = $components->find(
            new ComponentId($id),
        );

        if ($component === null) {
            throw new LogicException(
                sprintf(
                    'Theme component "%s" not found.',
                    $id,
                ),
            );
        }

        $value = $component->component();

        if (!$value instanceof $expectedClass) {
            throw new LogicException(
                sprintf(
                    'Theme component "%s" must be an instance of %s.',
                    $id,
                    $expectedClass,
                ),
            );
        }

        return $value;
    }
}
