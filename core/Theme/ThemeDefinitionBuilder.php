<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use Rombt\ThemeCore\Theme\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

final class ThemeComponentBuilder
{
    public function __construct(
        private readonly ThemeComponentBuilderRegistry $registry,
    ) {
    }

    public function build(
        ThemeConfigurationPackage $package,
    ): ThemeComponentCollection {
        $components = new ThemeComponentCollection();

        foreach ($package->domains() as $domain) {
            $builder = $this->registry->builderFor($domain);

            $components->add(
                $builder->build($domain),
            );
        }

        return $components;
    }
}
