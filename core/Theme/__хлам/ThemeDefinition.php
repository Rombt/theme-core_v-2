<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

final readonly class ThemeDefinition
{
    public function __construct(
        private ThemeMetadata $metadata,
        private ThemeComponentCollection $components,
    ) {
    }

    public function metadata(): ThemeMetadata
    {
        return $this->metadata;
    }

    public function components(): ThemeComponentCollection
    {
        return $this->components;
    }
}
