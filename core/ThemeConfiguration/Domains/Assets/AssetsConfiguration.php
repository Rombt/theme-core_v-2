<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class AssetsConfiguration implements
    ConfigurationDomainInterface
{
    private AssetCollection $assets;

    /**
     * @param array<string, array<string, mixed>> $assets
     */
    public function __construct(array $assets)
    {
        $collection = [];

        foreach ($assets as $id => $asset) {
            $collection[] = new Asset(
                id: $id,
                type: (string) ($asset['type'] ?? ''),
                entry: (string) ($asset['entry'] ?? ''),
                dependencies: array_values(
                    $asset['dependencies'] ?? [],
                ),
            );
        }

        $this->assets = new AssetCollection($collection);
    }

    public function assets(): AssetCollection
    {
        return $this->assets;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->assets as $asset) {
            $result[$asset->id()] = [
                'type' => $asset->type(),
                'entry' => $asset->entry(),
                'dependencies' => $asset->dependencies(),
            ];
        }

        return $result;
    }
}
