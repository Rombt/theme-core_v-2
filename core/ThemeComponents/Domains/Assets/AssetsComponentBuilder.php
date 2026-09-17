<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Assets;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\Asset as ConfigurationAsset;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsConfiguration;

final readonly class AssetsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof AssetsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent {
        /** @var AssetsConfiguration $configuration */
        $configuration = $domain->configuration();

        $assets = [];

        foreach ($configuration->assets() as $configurationAsset) {
            $assets[] = $this->buildAsset($configurationAsset);
        }

        return new ThemeComponent(
            id: new ComponentId('assets'),
            component: new AssetsComponent(
                new AssetCollection($assets),
            ),
        );
    }

    private function buildAsset(
        ConfigurationAsset $asset,
    ): Asset {
        $files = [];

        foreach ($asset->resource()->files() as $file) {
            $files[] = new AssetResourceFile(
                path: $file->path(),
            );
        }

        return new Asset(
            id: $asset->id(),
            name: $asset->name(),
            type: AssetType::from(
                $asset->type()->value(),
            ),
            resource: new AssetResource(
                path: $asset->resource()->path(),
                files: $files,
            ),
            destPath: $asset->destPath(),
            dependencies: $asset->dependencies(),
            configuration: $asset->configuration(),
        );
    }
}
