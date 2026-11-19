<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects;

final readonly class ResolvedAssetDependency
{
    public function __construct(
        private string $assetId,
        private AssetType $type,
    ) {
    }

    public function assetId(): string
    {
        return $this->assetId;
    }

    public function type(): AssetType
    {
        return $this->type;
    }
}
