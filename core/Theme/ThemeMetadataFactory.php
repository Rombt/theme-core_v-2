<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

final class ThemeMetadataFactory
{
    /**
     * @param array<string, mixed> $configuration
     */
    public function create(
        array $configuration,
    ): ThemeMetadata {
        return new ThemeMetadata(
            name: (string) ($configuration['name'] ?? ''),
            description: (string) ($configuration['description'] ?? ''),
            version: (string) ($configuration['version'] ?? ''),
            author: (string) ($configuration['author'] ?? ''),
            authorUri: (string) ($configuration['author_uri'] ?? ''),
            themeUri: (string) ($configuration['theme_uri'] ?? ''),
            textDomain: (string) ($configuration['text_domain'] ?? ''),
        );
    }
}
