<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

final readonly class AssetsThemeIrResolver implements ThemeIrResolverInterface
{
    public function supports(ThemeComponent $component): bool
    {
        return $component->component() instanceof AssetsComponent;
    }

    public function resolve(ThemeComponent $component): ThemeIrCollection
    {
        /** @var AssetsComponent $assets */
        $assets = $component->component();

        return new ThemeIrCollection([
            new AssetIr(
                id: new IrId($component->id()->value()),
                assets: $assets->assets(),
            ),

        ]);
    }
}
