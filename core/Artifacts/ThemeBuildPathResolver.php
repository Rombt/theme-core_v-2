<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Theme\ThemeDefinition;

final class ThemeBuildPathResolver
{
    public function __construct(
        private readonly string $buildRoot
    ) {
    }

    public function resolveThemePath(ThemeDefinition $theme): string
    {

        echo '$theme = ';
        print_r($theme);
        echo PHP_EOL;

        return rtrim($this->buildRoot, '/\\') . DIRECTORY_SEPARATOR . $theme->metadata()->name();
    }
}
