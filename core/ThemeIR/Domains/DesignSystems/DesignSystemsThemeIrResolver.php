<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\DesignSystems;

use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\DesignSystems\DesignSystemsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeConceptInterface;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;

final readonly class DesignSystemsThemeIrResolver implements ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
    ): ThemeConceptInterface {
        $themeComponent = $components->find(
            new ComponentId('design-systems'),
        );

        if ($themeComponent === null) {
            throw new RuntimeException(
                'Theme component "design-systems" not found.',
            );
        }

        $component = $themeComponent->component();

        if (!$component instanceof DesignSystemsComponent) {
            throw new RuntimeException(
                'Theme component "design-systems" must contain DesignSystemsComponent.',
            );
        }

        return new DesignSystemIr(
            id: new IrId('design-systems'),
            configuration: $component->designSystems(),
        );
    }
}
