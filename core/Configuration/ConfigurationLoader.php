<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

use Rombt\ThemeCore\Configuration\Exception\InvalidConfigurationException;

final class ConfigurationLoader
{
    /**
     * @return array<string, mixed>
     */
    public function load(string $path): array
    {
        $configuration = require $path;

        if (!is_array($configuration)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Configuration file [%s] must return array.',
                    $path
                )
            );
        }

        return $configuration;
    }
}
