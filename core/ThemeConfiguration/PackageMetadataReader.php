<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use RuntimeException;

final class PackageMetadataReader
{
    public function read(string $packagePath): PackageMetadata
    {
        $file = $packagePath . '/package.php';

        if (!is_file($file)) {
            throw new RuntimeException(
                sprintf(
                    'Package file "%s" not found.',
                    $file
                )
            );
        }

        $data = require $file;

        if (!is_array($data)) {
            throw new RuntimeException(
                sprintf(
                    'Package file "%s" must return array.',
                    $file
                )
            );
        }

        $name = $data['name'] ?? null;
        $version = $data['version'] ?? null;

        if (!is_string($name)) {
            throw new RuntimeException(
                sprintf(
                    'Package "%s" must define "name".',
                    $file
                )
            );
        }

        if (!is_string($version)) {
            throw new RuntimeException(
                sprintf(
                    'Package "%s" must define "version".',
                    $file
                )
            );
        }

        return new PackageMetadata(
            name: $name,
            version: $version,
        );
    }
}
