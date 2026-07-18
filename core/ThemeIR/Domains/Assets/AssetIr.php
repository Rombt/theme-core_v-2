<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetCollection;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIr;

final readonly class AssetIr extends ThemeIr
{
    public function __construct(
        IrId $id,
        private AssetCollection $assets,
    ) {
        parent::__construct($id);
    }

    public function assets(): AssetCollection
    {
        return $this->assets;
    }
}
