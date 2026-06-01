<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

use Rombt\ThemeCore\Configuration\Exception\ConfigurationNotFoundException;

final class ConfigurationDiscovery
{
    public function discover(string $projectRoot): string
    {
        $path = $projectRoot . '/config/theme-core.config.php';

        if (!is_file($path)) {
            throw new ConfigurationNotFoundException(
                sprintf(
                    'Configuration file [%s] not found.',
                    $path
                )
            );
        }

        return $path;
    }
}
