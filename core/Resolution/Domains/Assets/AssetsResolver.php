<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Assets;

use Rombt\ThemeCore\Resolution\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\Theme\ComponentId;
use Rombt\ThemeCore\Theme\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\Theme\ThemeComponentCollection;
use Rombt\ThemeCore\Theme\ThemeIr;

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
