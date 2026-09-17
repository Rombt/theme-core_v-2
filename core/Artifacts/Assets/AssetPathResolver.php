<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Assets;

use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ResourceFile;

final readonly class AssetPathResolver
{
    public function destination(
        Asset $asset,
        ResourceFile $file,
    ): string {
        $directory = trim(
            $asset->destPath(),
            '/\\',
        );

        $filename = ltrim(
            $file->path(),
            '/\\',
        );

        if ($directory === '') {
            return $filename;
        }

        return $directory
            . DIRECTORY_SEPARATOR
            . $filename;
    }
}
