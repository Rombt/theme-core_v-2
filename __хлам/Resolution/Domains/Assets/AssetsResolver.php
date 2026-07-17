<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Assets;

use Rombt\ThemeCore\Resolution\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeComponents\ThemeIr;

final readonly class AssetsResolver implements ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
        ThemeIr $ir,
    ): ThemeIr {
        $id = new ComponentId('assets');

        if (!$components->has($id)) {
            return $ir;
        }

        $component = $components
            ->get($id)
            ->component();

        if (!$component instanceof AssetsComponent) {
            return $ir;
        }

        $ir->set(
            'assets',
            new AssetsIr(
                $component->assets(),
            ),
        );

        return $ir;
    }
}
