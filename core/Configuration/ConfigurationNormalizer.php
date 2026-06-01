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
     *
     * @return array<string, mixed>
     */
    public function normalize(array $configuration): array
    {
        $configuration['paths']['build']
            = $this->normalizePath(
                $configuration['paths']['build']
            );

        $configuration['paths']['cache']
            = $this->normalizePath(
                $configuration['paths']['cache']
            );

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
