<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use RuntimeException;
use Rombt\ThemeCore\Theme\Contracts\ThemeConfigurationLoaderInterface;

final class ThemeConfigurationLoader implements ThemeConfigurationLoaderInterface
{
    public function __construct(
        private readonly string $file
    ) {
    }

    public function load(): ThemeConfiguration
    {
        if (!is_file($this->file)) {
            throw new RuntimeException(
                sprintf(
                    'Theme configuration file "%s" not found.',
                    $this->file
                )
            );
        }

        $data = require $this->file;

        if (!is_array($data)) {
            throw new RuntimeException(
                'Theme configuration must return array.'
            );
        }

        return new ThemeConfiguration($data);
    }
}
