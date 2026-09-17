<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Assets\Contracts;

use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ResourceFile;

interface AssetResourceReaderInterface
{
    public function read(
        Asset $asset,
        ResourceFile $file,
    ): string;
}
