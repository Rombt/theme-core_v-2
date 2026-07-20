<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Compositions;

use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

final readonly class CompositionsThemeIrResolver implements ThemeIrResolverInterface
{
    public function supports(ThemeComponent $component): bool
    {
        return $component->component() instanceof CompositionsComponent;
    }

    public function resolve(ThemeComponent $component): ThemeIrCollection
    {
        /** @var CompositionsComponent $compositions */
        $compositions = $component->component();

        return new ThemeIrCollection([
            new CompositionIr(
                id: new IrId($component->id()->value()),
                compositions: $compositions->compositions(),
            ),
        ]);
    }
}
