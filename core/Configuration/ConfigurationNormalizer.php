<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

use Rombt\ThemeCore\Configuration\ValueObject\OutputPath;
use Rombt\ThemeCore\Configuration\Exception\InvalidConfigurationException;

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
            $paths = [];
        }

        $output = $paths['output'] ?? 'build';

        $paths['output'] = $this->normalizeOutputPath(
            $output,
            $paths['bases'] ?? [],
        );

        $cache = $paths['cache'] ?? '.cache';

        $cache = is_string($cache)
        || is_int($cache)
        || is_float($cache)
        ? (string) $cache
        : '';

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

    private function normalizeOutputPath(
        mixed $output,
        mixed $bases,
    ): string {
        if (is_string($output)) {
            return OutputPath::relative($output)->resolve(
                $this->projectRoot,
            );
        }

        if (!is_array($output)) {
            return OutputPath::relative('build')->resolve(
                $this->projectRoot,
            );
        }

        if (isset($output['relative'])) {
            return OutputPath::relative(
                (string) $output['relative'],
            )->resolve(
                $this->projectRoot,
            );
        }

        if (isset($output['absolute'])) {
            return OutputPath::absolute(
                (string) $output['absolute'],
            )->resolve(
                $this->projectRoot,
            );
        }

        if (isset($output['base'])) {
            $base = $output['base'];

            if (!is_string($base)) {
                throw new InvalidConfigurationException(
                    'Configuration field [paths.output.base] must be string.'
                );
            }

            $path = $output['path'] ?? '';

            if (!is_string($path)) {
                throw new InvalidConfigurationException(
                    'Configuration field [paths.output.path] must be string.'
                );
            }

            $resolvedBases = is_array($bases)
                ? $bases
                : [];

            return OutputPath::base(
                $base,
                $path,
            )->resolve(
                $this->projectRoot,
                $resolvedBases,
            );
        }

        throw new InvalidConfigurationException(
            'Configuration field [paths.output] must contain one of: relative, absolute, base.'
        );
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
