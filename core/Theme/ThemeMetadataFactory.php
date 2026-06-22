<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use Rombt\ThemeCore\ThemeConfiguration\PackageMetadata;

final class ThemeMetadataFactory
{
    public function create(
        PackageMetadata $metadata,
    ): ThemeMetadata {
        return new ThemeMetadata(
            name: $metadata->name(),
            description: '',
            version: $metadata->version(),
        );
    }
}
