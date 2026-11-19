<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Assets;

use LogicException;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ResourceFile;

final readonly class AssetPathResolver
{
    public function destination(
        Asset $asset,
        ResourceFile $file,
    ): string {
        $destination = $file->destPath() ?? $asset->destPath();

        if ($destination === '') {
            throw new LogicException(
                sprintf(
                    'Asset "%s" has no destination path for resource file "%s".',
                    $asset->id(),
                    $file->path(),
                ),
            );
        }

        return $destination;
    }
}
