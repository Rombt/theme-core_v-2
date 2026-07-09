<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageDiscoveryInterface;

final readonly class FilesystemPackageDiscovery implements PackageDiscoveryInterface
{
    public function discover(string $packagesPath): iterable
    {
        if (!is_dir($packagesPath)) {
            throw new RuntimeException(
                sprintf(
                    'Theme packages directory "%s" not found.',
                    $packagesPath,
                ),
            );
        }

        foreach (scandir($packagesPath) ?: [] as $directory) {
            if ($directory === '.' || $directory === '..') {
                continue;
            }

            $packagePath = $packagesPath . DIRECTORY_SEPARATOR . $directory;

            if (!is_dir($packagePath)) {
                continue;
            }

            $configuration = $this->loadPackageConfiguration($packagePath);

            yield new DiscoveredPackage(
                id: new PackageId($directory),
                configuration: $configuration,
                path: $packagePath,
            );
        }
    }

    private function loadPackageConfiguration(
        string $packagePath,
    ): array {
        $file = $packagePath . '/package.php';

        if (!is_file($file)) {
            throw new RuntimeException(
                sprintf(
                    'Package file "%s" not found.',
                    $file,
                ),
            );
        }

        $configuration = require $file;

        if (!is_array($configuration)) {
            throw new RuntimeException(
                sprintf(
                    'Package file "%s" must return array.',
                    $file,
                ),
            );
        }

        return $configuration;
    }
}
