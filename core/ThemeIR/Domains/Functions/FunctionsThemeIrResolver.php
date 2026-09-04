<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Functions;

use LogicException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionDeclaration;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionDeclarationCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionRequirementCollector;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Functions;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Resource;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\ValueObjects\FunctionType;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrFinalResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

final readonly class FunctionsThemeIrResolver implements ThemeIrFinalResolverInterface
{
    public function __construct(
        private FunctionRequirementCollector $requirementCollector,
    ) {
    }

    public function resolve(ThemeComponentCollection $components, ThemeIR $themeIr): Functions
    {
        $component = $this->getComponent($components);

        $declarations = [];

        foreach ($component->functions() as $function) {
            $resource = $function->resource();

            if ($resource === null) {
                throw new LogicException(
                    sprintf(
                        'Function "%s" must define a resource.',
                        $function->id(),
                    ),
                );
            }

            $declarations[] = new FunctionDeclaration(
                id: $function->id(),
                type: new FunctionType(
                    $function->type(),
                ),
                resource: new Resource(
                    $resource,
                ),
                name: $function->name(),
                description: $function->description(),
                configuration: $function->configuration(),
            );
        }

        return new Functions(
            id: new IrId('functions'),
            declarations: new FunctionDeclarationCollection(
                $declarations,
            ),
            requirements: $this->requirementCollector->collect(
                $themeIr,
            ),
        );
    }

    private function getComponent(ThemeComponentCollection $components): FunctionsComponent
    {
        $themeComponent = $components->find(new ComponentId('functions'));

        if ($themeComponent === null) {
            throw new LogicException(
                'Theme component "functions" not found.',
            );
        }

        $component = $themeComponent->component();

        if (!$component instanceof FunctionsComponent) {
            throw new LogicException(
                sprintf(
                    'Theme component "functions" must be an instance of %s.',
                    FunctionsComponent::class,
                ),
            );
        }

        return $component;
    }
}
