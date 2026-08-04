<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeConceptInterface;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;

final readonly class AssetsThemeIrResolver implements ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
    ): ThemeConceptInterface {
        $themeComponent = $components->find(
            new ComponentId('assets'),
        );

        if ($themeComponent === null) {
            throw new RuntimeException(
                'Theme component "assets" not found.',
            );
        }

        $component = $themeComponent->component();

        if (!$component instanceof AssetsComponent) {
            throw new RuntimeException(
                'Theme component "assets" must contain AssetsComponent.',
            );
        }

        return new AssetIr(
            id: new IrId('assets'),
            assets: $component->assets(),
        );
    }
}
