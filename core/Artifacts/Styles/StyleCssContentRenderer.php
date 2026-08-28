<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Styles;

use Rombt\ThemeCore\Artifacts\Styles\Contracts\StyleCssContentRendererInterface;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

final readonly class StyleCssContentRenderer implements
    StyleCssContentRendererInterface
{
    public function render(ThemeConfigurationPackage $package): string
    {
        $configuration = $package
            ->package()
            ->package()
            ->configuration();

        return sprintf(
            "/*\n"
            . "Theme Name: %s\n"
            . "Description: %s\n"
            . "Version: %s\n"
            . "Author: %s\n"
            . "Author URI: %s\n"
            . "Theme URI: %s\n"
            . "Text Domain: %s\n"
            . "*/\n",
            $configuration['name'] ?? '',
            $configuration['description'] ?? '',
            $configuration['version'] ?? '',
            $configuration['author'] ?? '',
            $configuration['author_uri'] ?? '',
            $configuration['theme_uri'] ?? '',
            $configuration['text_domain'] ?? '',
        );
    }
}
