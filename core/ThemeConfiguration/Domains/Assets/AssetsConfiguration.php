<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\Definitions\FunctionDefinition;

final readonly class AssetsConfiguration implements
    ConfigurationDomainInterface
{
    private AssetCollection $assets;

    /**
     * @param array<string, array<string, array<string, mixed>>> $assets
     */
    public function __construct(array $assets)
    {
        $collection = [];

        foreach ($assets as $definitions) {
            foreach ($definitions as $id => $asset) {
                $collection[] = $this->createAsset(
                    id: $id,
                    asset: $asset,
                );
            }
        }

        $this->assets = new AssetCollection($collection);
    }

    /**
     * @param array<string, mixed> $asset
     */
    private function createAsset(
        string $id,
        array $asset,
    ): Asset {
        return new Asset(
            id: $id,
            name: (string) ($asset['name'] ?? ''),
            type: new AssetType(
                (string) ($asset['type'] ?? ''),
            ),
            resource: $this->createResource(
                $asset['resource'] ?? null,
            ),
            destPath: (string) ($asset['dest_path'] ?? ''),
            dependencies: array_values(
                $asset['dependencies'] ?? [],
            ),
            configuration: is_array($asset['configuration'] ?? null)
                ? $asset['configuration']
                : [],
            function: $this->createFunctionDefinition(
                $asset['function'] ?? null,
            ),
        );
    }

    /**
     * @param mixed $function
     */
    private function createFunctionDefinition(
        mixed $function,
    ): ?FunctionDefinition {
        if (!is_array($function)) {
            return null;
        }

        return new FunctionDefinition(
            enabled: (bool) ($function['enabled'] ?? false),
            order: (int) ($function['order'] ?? 0),
        );
    }

    private function createResource(
        mixed $resource,
    ): Resource {
        if (!is_array($resource)) {
            return new Resource(
                path: (string) $resource,
            );
        }

        $files = [];

        foreach ($resource['files'] ?? [] as $file) {
            $files[] = new ResourceFile(
                path: (string) $file,
            );
        }

        return new Resource(
            path: (string) ($resource['path'] ?? ''),
            files: $files,
        );
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
                'type' => $asset->type()->value(),
                'resource' => [
                    'path' => $asset->resource()->path(),
                    'files' => array_map(
                        static fn(ResourceFile $file): string
                            => $file->path(),
                        $asset->resource()->files(),
                    ),
                ],
                'dest_path' => $asset->destPath(),
                'name' => $asset->name(),
                'dependencies' => $asset->dependencies(),
                'configuration' => $asset->configuration(),
                'function' => $asset->function()?->toArray(),
            ];
        }

        return $result;
    }
}
