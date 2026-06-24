<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageDiscoveryInterface;
use Rombt\ThemeCore\ThemeConfiguration\PackageMetadataReader;
use RuntimeException;

final readonly class FilesystemPackageDiscovery implements PackageDiscoveryInterface
{
    public function __construct(
        private PackageMetadataReader $metadataReader,
    ) {
    }

    public function discover($packagesPath): iterable
    {

        if (!is_dir($packagesPath)) {
            throw new RuntimeException(
                sprintf('Theme packages directory "%s" not found.', $packagesPath)
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

            yield new DiscoveredPackage(
                id: new PackageId($directory),
                metadata: $this->metadataReader->read($packagePath),
                path: $packagePath,
            );
        }
    }
}
