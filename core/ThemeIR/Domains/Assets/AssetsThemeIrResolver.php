<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use LogicException;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\Asset as ComponentAsset;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Exceptions\AssetDependencyResolutionException;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\AssetType;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\ResolvedAssetDependency;
use Rombt\ThemeCore\ThemeIR\FunctionDefinition;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\Domains\Functions\Resource as FunctionResource;

final readonly class AssetsThemeIrResolver implements ThemeIrResolverInterface
{
    public function __construct(
        private DiagnosticsService $diagnostics,
    ) {
    }

    public function resolve(
        ThemeComponentCollection $components,
    ): AssetIr {
        $component = $this->getComponent($components);
        $componentAssets = $component->assets()->all();
        $assetsById = [];

        foreach ($componentAssets as $asset) {
            $id = $asset->id();

            if (isset($assetsById[$id])) {
                throw new AssetDependencyResolutionException(
                    sprintf('Asset ID "%s" is declared more than once; dependency references are ambiguous.', $id),
                );
            }

            $assetsById[$id] = $asset;
        }

        $dependencyIds = [];

        foreach ($componentAssets as $asset) {
            $assetId = $asset->id();
            $seen = [];
            $uniqueDependencies = [];
            $duplicates = [];

            foreach ($asset->dependencies() as $dependencyId) {
                if (isset($seen[$dependencyId])) {
                    $duplicates[] = $dependencyId;
                    continue;
                }

                $seen[$dependencyId] = true;
                $uniqueDependencies[] = $dependencyId;
            }

            if ($duplicates !== []) {
                $this->diagnostics->create(
                    DiagnosticLevel::WARNING,
                    sprintf(
                        'Duplicate dependencies declared for asset "%s" were ignored: %s.',
                        $assetId,
                        implode(', ', array_unique($duplicates)),
                    ),
                    new DiagnosticContext([
                        'domain' => 'assets',
                        'asset_id' => $assetId,
                        'duplicate_dependency_ids' => array_values(array_unique($duplicates)),
                    ]),
                );
            }

            foreach ($uniqueDependencies as $dependencyId) {
                if ($dependencyId === $assetId) {
                    throw new AssetDependencyResolutionException(
                        sprintf('Asset "%s" cannot depend on itself.', $assetId),
                    );
                }

                $dependency = $assetsById[$dependencyId] ?? null;

                if ($dependency === null) {
                    throw new AssetDependencyResolutionException(
                        sprintf(
                            'Asset "%s" depends on missing asset "%s".',
                            $assetId,
                            $dependencyId,
                        ),
                    );
                }

                if (!$this->isCompatible($asset->type(), $dependency->type())) {
                    throw new AssetDependencyResolutionException(
                        sprintf(
                            'Asset "%s" (%s) cannot depend on asset "%s" (%s). Only Script-to-Script and Style-to-Style dependencies are supported.',
                            $assetId,
                            $asset->type()->value,
                            $dependencyId,
                            $dependency->type()->value,
                        ),
                    );
                }
            }

            $dependencyIds[$assetId] = $uniqueDependencies;
        }

        $this->assertAcyclic($dependencyIds);

        $assets = [];

        foreach ($componentAssets as $asset) {
            $resolvedDependencies = [];

            foreach ($dependencyIds[$asset->id()] as $dependencyId) {
                $resolvedDependencies[] = new ResolvedAssetDependency(
                    assetId: $dependencyId,
                    type: AssetType::from($assetsById[$dependencyId]->type()->value),
                );
            }

            $assets[] = $this->buildAsset($asset, $resolvedDependencies);
        }

        return new AssetIr(
            id: new IrId('assets'),
            assets: new AssetCollection($assets),
        );
    }

    private function isCompatible(
        \Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType $source,
        \Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType $target,
    ): bool {
        return ($source === \Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType::Script
                && $target === \Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType::Script)
            || ($source === \Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType::Style
                && $target === \Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType::Style);
    }

    /**
     * @param array<string, list<string>> $dependencies
     */
    private function assertAcyclic(array $dependencies): void
    {
        $states = [];
        $stack = [];

        $visit = function (string $assetId) use (&$visit, &$states, &$stack, $dependencies): void {
            $states[$assetId] = 1;
            $stack[] = $assetId;

            foreach ($dependencies[$assetId] as $dependencyId) {
                $state = $states[$dependencyId] ?? 0;

                if ($state === 1) {
                    $cycleStart = array_search($dependencyId, $stack, true);
                    $cycle = array_slice($stack, $cycleStart === false ? 0 : $cycleStart);
                    $cycle[] = $dependencyId;

                    throw new AssetDependencyResolutionException(
                        sprintf('Circular asset dependency detected: %s.', implode(' → ', $cycle)),
                    );
                }

                if ($state === 0) {
                    $visit($dependencyId);
                }
            }

            array_pop($stack);
            $states[$assetId] = 2;
        };

        foreach (array_keys($dependencies) as $assetId) {
            if (($states[$assetId] ?? 0) === 0) {
                $visit($assetId);
            }
        }
    }

    private function getComponent(
        ThemeComponentCollection $components,
    ): AssetsComponent {
        $themeComponent = $components->find(new ComponentId('assets'));

        if ($themeComponent === null) {
            throw new LogicException('Theme component "assets" not found.');
        }

        $component = $themeComponent->component();

        if (!$component instanceof AssetsComponent) {
            throw new LogicException(sprintf(
                'Theme component "assets" must be an instance of %s.',
                AssetsComponent::class,
            ));
        }

        return $component;
    }

    /**
     * @param list<ResolvedAssetDependency> $dependencies
     */
    private function buildAsset(ComponentAsset $asset, array $dependencies): Asset
    {
        $files = [];

        foreach ($asset->resource()->files() as $file) {
            $files[] = new ResourceFile(
                path: $file->path(),
                destPath: $file->destPath(),
            );
        }

        return new Asset(
            id: $asset->id(),
            name: $asset->name(),
            type: AssetType::from($asset->type()->value),
            resource: new Resource(
                path: $asset->resource()->path(),
                files: $files,
            ),
            destPath: $asset->destPath(),
            dependencies: $dependencies,
            configuration: $asset->configuration(),
            function: $asset->function() !== null
                ? new FunctionDefinition(
                    enabled: $asset->function()->enabled(),
                    resource: new FunctionResource($this->buildFunctionResource($asset)),
                    order: $asset->function()->order(),
                )
                : null,
        );
    }

    private function buildFunctionResource(ComponentAsset $asset): string
    {
        return sprintf('assets/%s/%s', $asset->type()->value, $asset->id());
    }
}
