<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use Rombt\ThemeCore\Theme\Contracts\ThemeDefinitionBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ValidatedPackage;

final readonly class ThemeDefinitionBuilder implements ThemeDefinitionBuilderInterface
{
    public function __construct(
        private ThemeMetadataFactory $metadataFactory,
        private ThemeComponentBuilderRegistry $builders,
    ) {
    }

    public function build(
        ValidatedPackage $package,
    ): ThemeDefinition {
        $components = [];

        foreach ($package->package()->domains()->all() as $domain) {
            foreach ($this->builders->all() as $builder) {
                if (!$builder->supports($domain)) {
                    continue;
                }

                $components[] = $builder->build($domain);

                break;
            }
        }

        return new ThemeDefinition(
            metadata: $this->metadataFactory->create(
                $package->package()->configuration(),
            ),
            components: new ThemeComponentCollection($components),
        );
    }
}
