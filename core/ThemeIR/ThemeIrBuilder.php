<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrBuilderInterface;

final readonly class ThemeIrBuilder implements ThemeIrBuilderInterface
{
    public function __construct(private ThemeIrResolverRegistry $registry)
    {
    }

    public function build(ThemeComponentCollection $components): ThemeIr
    {
        $themeIr = new ThemeIr();

        foreach ($this->registry->resolvers() as $resolver) {
            $themeIr->add($resolver->resolve($components));
        }

        return $themeIr;
    }
}
