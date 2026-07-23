<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentCollectionBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

final class ThemeComponentBuilder implements ThemeComponentCollectionBuilderInterface
{
    public function __construct(private readonly ThemeComponentBuilderRegistry $registry)
    {
    }

    public function build(ThemeConfigurationPackage $package): ThemeComponentCollection
    {

        $components = new ThemeComponentCollection();

        foreach ($this->registry->buildersFor($package) as $entry) {
            $components->add(
                $entry['builder']->build(
                    $entry['domain'],
                    $components,
                ),
            );
        }

        return $components;
    }
}
