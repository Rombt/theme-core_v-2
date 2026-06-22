<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use Rombt\ThemeCore\Theme\Contracts\ThemeDefinitionBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ValidatedPackage;

final readonly class ThemeDefinitionBuilder implements ThemeDefinitionBuilderInterface
{
    public function __construct(
        private ThemeMetadataFactory $metadataFactory,
    ) {
    }

    public function build(
        ValidatedPackage $package,
    ): ThemeDefinition {
        return new ThemeDefinition(
            metadata: $this->metadataFactory->create(
                $package->package()->metadata(),
            ),
            components: new ThemeComponentCollection(),
        );
    }
}
