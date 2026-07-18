<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrBuilderInterface;

final readonly class ThemeIrBuilder implements ThemeIrBuilderInterface
{
    public function __construct(
        private ThemeIrResolverRegistry $registry,
    ) {
    }

    public function build(ThemeComponentCollection $components): ThemeIrCollection
    {
        $collection = new ThemeIrCollection();

        foreach ($components as $component) {
            $resolver = $this->registry->resolverFor($component);

            $collection = $collection->merge(
                $resolver->resolve($component),
            );
        }

        return $collection;
    }
}
