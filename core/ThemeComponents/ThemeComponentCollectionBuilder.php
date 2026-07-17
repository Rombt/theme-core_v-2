<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentCollectionBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

final class ThemeComponentCollectionBuilder implements ThemeComponentCollectionBuilderInterface
{
    /**
     * @param iterable<ThemeComponentBuilderInterface> $builders
     */
    public function __construct(
        private readonly iterable $builders,
    ) {
    }

    public function build(ThemeConfigurationPackage $package): ThemeComponentCollection
    {
        $collection = new ThemeComponentCollection();

        foreach ($this->builders as $builder) {
            foreach ($package->domains() as $domain) {
                if (!$builder->supports($domain)) {
                    continue;
                }

                $collection->add(
                    $builder->build($domain)
                );

                break;
            }
        }

        return $collection;
    }
}
