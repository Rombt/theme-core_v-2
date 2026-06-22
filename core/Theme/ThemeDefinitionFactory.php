<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

final class ThemeDefinitionFactory
{
    public function create(
        ThemeConfiguration $configuration
    ): ThemeDefinition {
        return new ThemeDefinition(
            metadata: new ThemeMetadata(
                name: (string) $configuration->get('theme.name'),
                description: (string) $configuration->get('theme.description', ''),
                version: (string) $configuration->get('theme.version', ''),
                author: (string) $configuration->get('theme.author', ''),
                authorUri: (string) $configuration->get('theme.author_uri', ''),
                themeUri: (string) $configuration->get('theme.theme_uri', ''),
                textDomain: (string) $configuration->get('theme.text_domain', ''),
            )
        );
    }
}
