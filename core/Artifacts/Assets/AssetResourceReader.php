<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Assets;

use RuntimeException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Assets\Contracts\AssetResourceReaderInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ResourceFile;

final readonly class AssetResourceReader implements AssetResourceReaderInterface
{
    private string $resourcePackage;

    public function __construct(
        Application $app,
        private string $architecture,
    ) {
        $configuration = $app->getContext()->get(
            ApplicationContextKeys::CONFIGURATION,
        );

        $this->resourcePackage = $configuration->get(
            'theme.resource_package',
        );
    }

    public function read(
        Asset $asset,
        ResourceFile $file,
    ): string {
        $path = $this->resourcePath(
            $asset,
            $file,
        );

        if (!is_file($path)) {
            throw new RuntimeException(
                sprintf(
                    'Asset resource "%s" was not found.',
                    $path,
                ),
            );
        }

        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException(
                sprintf(
                    'Unable to read asset resource "%s".',
                    $path,
                ),
            );
        }

        return $content;
    }

    private function resourcePath(
        Asset $asset,
        ResourceFile $file,
    ): string {
        return rtrim(
            $this->resourcePackage,
            '/\\',
        )
            . DIRECTORY_SEPARATOR
            . 'assets'
            . DIRECTORY_SEPARATOR
            . $asset->type()->value
            . DIRECTORY_SEPARATOR
            . $asset->id()
            . DIRECTORY_SEPARATOR
            . $this->architecture
            . DIRECTORY_SEPARATOR
            . ltrim($file->path(), '/\\');
    }
}
