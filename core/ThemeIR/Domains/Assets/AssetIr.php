<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeConcept;

final readonly class AssetIr extends ThemeConcept
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
