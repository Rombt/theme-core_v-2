<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution;

use Rombt\ThemeCore\Theme\ThemeDefinition;
use Rombt\ThemeCore\Theme\ThemeIr;

final readonly class ThemeIrBuilder
{
    public function __construct(
        private ThemeIrResolverRegistry $registry,
    ) {
    }

    public function build(
        ThemeDefinition $theme,
    ): ThemeIr {
        $ir = new ThemeIr();

        foreach ($this->registry->all() as $resolver) {
            $ir = $resolver->resolve(
                $theme->components(),
                $ir,
            );
        }

        return $ir;
    }
}
