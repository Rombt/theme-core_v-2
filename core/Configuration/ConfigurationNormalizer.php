<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

final class ConfigurationNormalizer
{
    public function __construct(
        private readonly string $projectRoot,
    ) {
    }

    /**
     * @param array<string, mixed> $configuration
     * @return array<string, mixed>
     */
    public function normalize(array $configuration): array
    {
        $paths = $configuration['paths'] ?? [];

        if (!is_array($paths)) {
            $paths = [
            'build' => '',
            'cache' => '',
            ];
        }

        $build = $paths['build'] ?? '';
        $cache = $paths['cache'] ?? '';

        $build = is_string($build) || is_int($build) || is_float($build)
        ? (string) $build
        : '';

        $cache = is_string($cache) || is_int($cache) || is_float($cache)
        ? (string) $cache
        : '';

        $paths['build'] = $this->normalizePath($build);
        $paths['cache'] = $this->normalizePath($cache);

        $configuration['paths'] = $paths;

        // Theme

        $theme = $configuration['theme'] ?? [];

        if (!is_array($theme)) {
            $theme = [];
        }

        $packagesPath = $theme['packages_path'] ?? '';
        $packagesPath = is_string($packagesPath)
            || is_int($packagesPath)
            || is_float($packagesPath)
            ? (string) $packagesPath
            : '';
        $theme['packages_path'] = $this->normalizePath($packagesPath);

        $resourcePackage = $theme['resource_package'] ?? '';
        $resourcePackage = is_string($resourcePackage)
            || is_int($resourcePackage)
            || is_float($resourcePackage)
            ? (string) $resourcePackage
            : '';
        $theme['resource_package'] = $this->normalizePath($resourcePackage);


        $configuration['theme'] = $theme;

        return $configuration;
    }

    private function normalizePath(string $path): string
    {
        return rtrim(
            $this->projectRoot,
            '/\\'
        ) . DIRECTORY_SEPARATOR . ltrim(
            $path,
            '/\\'
        );
    }
}
