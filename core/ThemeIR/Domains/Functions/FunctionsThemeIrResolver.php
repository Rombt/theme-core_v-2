<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Functions;

use LogicException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionDeclaration;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionDeclarationCollection;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Functions;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Resource;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\ValueObjects\FunctionType;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;

final readonly class FunctionsThemeIrResolver implements ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
    ): Functions {
        $component = $this->getComponent($components);

        $declarations = [];

        foreach ($component->functions() as $function) {
            $declarations[] = new FunctionDeclaration(
                id: $function->id(),
                type: new FunctionType(
                    $function->type(),
                ),
                resource: $function->resource() !== null
                    ? new Resource($function->resource())
                    : null,
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
        );
    }

    private function getComponent(
        ThemeComponentCollection $components,
    ): FunctionsComponent {
        $themeComponent = $components->find(
            new ComponentId('functions'),
        );

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
