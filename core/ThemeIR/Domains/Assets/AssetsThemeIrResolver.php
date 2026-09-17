<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use LogicException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\Asset as ComponentAsset;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\AssetType;

final readonly class AssetsThemeIrResolver implements ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
    ): AssetIr {
        $component = $this->getComponent($components);

        $assets = [];

        foreach ($component->assets() as $asset) {
            $assets[] = $this->buildAsset($asset);
        }

        return new AssetIr(
            id: new IrId('assets'),
            assets: new AssetCollection($assets),
        );
    }

    private function getComponent(
        ThemeComponentCollection $components,
    ): AssetsComponent {
        $themeComponent = $components->find(
            new ComponentId('assets'),
        );

        if ($themeComponent === null) {
            throw new LogicException(
                'Theme component "assets" not found.',
            );
        }

        $component = $themeComponent->component();

        if (!$component instanceof AssetsComponent) {
            throw new LogicException(
                sprintf(
                    'Theme component "assets" must be an instance of %s.',
                    AssetsComponent::class,
                ),
            );
        }

        return $component;
    }

    private function buildAsset(
        ComponentAsset $asset,
    ): Asset {
        $files = [];

        foreach ($asset->resource()->files() as $file) {
            $files[] = new ResourceFile(
                path: $file->path(),
            );
        }

        return new Asset(
            id: $asset->id(),
            name: $asset->name(),
            type: AssetType::from(
                $asset->type()->value,
            ),
            resource: new Resource(
                path: $asset->resource()->path(),
                files: $files,
            ),
            destPath: $asset->destPath(),
            dependencies: $asset->dependencies(),
            configuration: $asset->configuration(),
        );
    }
}
