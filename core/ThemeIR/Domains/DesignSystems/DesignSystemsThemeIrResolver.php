<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\DesignSystems;

use Rombt\ThemeCore\ThemeComponents\Domains\DesignSystems\DesignSystemsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

final readonly class DesignSystemsThemeIrResolver implements ThemeIrResolverInterface
{
    public function supports(ThemeComponent $component): bool
    {
        return $component->component() instanceof DesignSystemsComponent;
    }

    public function resolve(ThemeComponent $component): ThemeIrCollection
    {
        /** @var DesignSystemsComponent $designSystems */
        $designSystems = $component->component();

        return new ThemeIrCollection([
            new DesignSystemIr(
                id: new IrId($component->id()->value()),
                configuration: $designSystems->designSystems(),
            ),
        ]);
    }
}
