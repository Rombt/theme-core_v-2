<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrBuilderInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\AssetsResolver;

final readonly class ThemeIrBuilder implements ThemeIrBuilderInterface
{
    public function __construct(
        private AssetsResolver $assetsResolver,
    ) {
    }

    public function build(
        ThemeComponentCollection $components,
    ): ThemeIR {
        return new ThemeIR(
            $this->assetsResolver->resolve($components),
        );
    }
}
