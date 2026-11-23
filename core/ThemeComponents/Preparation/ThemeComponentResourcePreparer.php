<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Preparation;

use RuntimeException;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionComponentCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionsComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions\FunctionDefinition;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Node;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodeCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodesComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;

/**
 * Prepares file-backed Theme Components before Resolution.
 *
 * Missing files are the only condition handled by the soft build mode.
 * Existing but unreadable files are left to their consumers and remain errors.
 */
final class ThemeComponentResourcePreparer
{
    public function prepare(
        ThemeComponentCollection $components,
        string $resourcePackage,
        string $architecture,
        bool $strict,
        DiagnosticsService $diagnostics,
    ): void {
        $this->prepareAssets($components, $resourcePackage, $architecture, $strict, $diagnostics);
        $this->prepareCompositions($components, $resourcePackage, $architecture, $strict, $diagnostics);
        $this->prepareNodes($components, $resourcePackage, $architecture, $strict, $diagnostics);
        $this->prepareFunctions($components, $resourcePackage, $architecture, $strict, $diagnostics);
    }

    private function prepareAssets(
        ThemeComponentCollection $components,
        string $root,
        string $architecture,
        bool $strict,
        DiagnosticsService $diagnostics,
    ): void {
        $component = $this->component($components, 'assets', AssetsComponent::class);
        if ($component === null) {
            return;
        }

        $assets = $component->assets()->all();
        $missingFiles = [];
        foreach ($assets as $asset) {
            $paths = [];

            foreach ($asset->resource()->files() as $file) {
                $path = $this->join(
                    $root,
                    $asset->resource()->path(),
                    $architecture,
                    $file->path(),
                );

                if (!is_file($path)) {
                    $paths[] = $path;
                }
            }

            if ($asset->function()?->enabled()) {
                $functionPath = $this->assetFunctionPath($root, $asset, $architecture);
                if (!is_file($functionPath)) {
                    $paths[] = $functionPath;
                }
            }

            if ($paths !== []) {
                $missingFiles[$asset->id()] = array_values(array_unique($paths));
            }
        }

        $excluded = array_fill_keys(array_keys($missingFiles), true);
        $dependencyCauses = [];
        $changed = true;

        while ($changed) {
            $changed = false;
            foreach ($assets as $asset) {
                $assetId = $asset->id();
                $causes = array_values(array_filter(
                    $asset->dependencies(),
                    static fn (string $dependency): bool => isset($excluded[$dependency]),
                ));

                if ($causes === []) {
                    continue;
                }

                $dependencyCauses[$assetId] = array_values(array_unique([
                    ...($dependencyCauses[$assetId] ?? []),
                    ...$causes,
                ]));

                if (!isset($excluded[$assetId])) {
                    $excluded[$assetId] = true;
                    $changed = true;
                }
            }
        }

        foreach ($assets as $asset) {
            $assetId = $asset->id();
            if (!isset($excluded[$assetId])) {
                continue;
            }

            $paths = $missingFiles[$assetId] ?? [];
            $causes = $dependencyCauses[$assetId] ?? [];
            $details = [];
            if ($paths !== []) {
                $details[] = 'missing files: ' . implode(', ', $paths);
            }
            if ($causes !== []) {
                $details[] = 'depends on excluded asset(s): ' . implode(', ', $causes);
            }

            $this->reportUnavailable(
                strict: $strict,
                diagnostics: $diagnostics,
                type: 'asset',
                id: $assetId,
                message: sprintf('Asset "%s" was excluded (%s).', $assetId, implode('; ', $details)),
                metadata: [
                    'asset_id' => $assetId,
                    'missing_files' => $paths,
                    'excluded_dependencies' => $causes,
                ],
            );
        }

        $remaining = array_values(array_filter(
            $assets,
            static fn (Asset $asset): bool => !isset($excluded[$asset->id()]),
        ));

        $components->replace(new ThemeComponent(
            new ComponentId('assets'),
            new AssetsComponent(new AssetCollection($remaining)),
        ));
    }

    private function prepareCompositions(
        ThemeComponentCollection $components,
        string $root,
        string $architecture,
        bool $strict,
        DiagnosticsService $diagnostics,
    ): void {
        $component = $this->component($components, 'compositions', CompositionsComponent::class);
        if ($component === null) {
            return;
        }

        foreach ($component->compositions() as $composition) {
            $resource = $composition->resource();
            if ($resource === null) {
                continue;
            }

            $path = $this->join(
                $root,
                'components',
                $resource,
                $architecture === 'classic' ? 'classic.php' : 'block.html',
            );

            if (!is_file($path)) {
                $this->reportUnavailable(
                    strict: $strict,
                    diagnostics: $diagnostics,
                    type: 'composition-resource',
                    id: $composition->id(),
                    message: sprintf('Composition resource for "%s" was excluded; file "%s" is missing.', $composition->id(), $path),
                    metadata: ['composition_id' => $composition->id(), 'resource' => $resource, 'missing_files' => [$path]],
                );
                $composition->markResourceSkipped();
            }
        }
    }

    private function prepareNodes(
        ThemeComponentCollection $components,
        string $root,
        string $architecture,
        bool $strict,
        DiagnosticsService $diagnostics,
    ): void {
        $component = $this->component($components, 'nodes', NodesComponent::class);
        if ($component === null) {
            return;
        }

        $prepared = [];
        foreach ($component->nodes()->all() as $node) {
            $resource = $node->resource();
            if ($resource === null) {
                $prepared[] = $node;
                continue;
            }

            $resourcePath = $this->join(
                $root,
                'components',
                $resource,
                $architecture === 'classic' ? 'classic.php' : 'block.html',
            );

            if (!is_file($resourcePath)) {
                $this->reportUnavailable(
                    strict: $strict,
                    diagnostics: $diagnostics,
                    type: 'template-resource',
                    id: $node->id(),
                    message: sprintf('Template resource for node "%s" was excluded; file "%s" is missing.', $node->id(), $resourcePath),
                    metadata: ['node_id' => $node->id(), 'resource' => $resource, 'missing_files' => [$resourcePath]],
                );

                $prepared[] = $this->copyNode($node, null, null, true);
                continue;
            }

            $function = $node->function();
            if ($function?->enabled()) {
                $functionPath = $this->join(
                    $root,
                    'components',
                    $resource,
                    $architecture === 'classic' ? 'function.classic.php' : 'function.block.html',
                );

                if (!is_file($functionPath)) {
                    $this->reportUnavailable(
                        strict: $strict,
                        diagnostics: $diagnostics,
                        type: 'template-function-resource',
                        id: $node->id(),
                        message: sprintf('Function resource for node "%s" was excluded; file "%s" is missing.', $node->id(), $functionPath),
                        metadata: ['node_id' => $node->id(), 'resource' => $resource, 'missing_files' => [$functionPath]],
                    );
                    $prepared[] = $this->copyNode($node, $resource, null, false);
                    continue;
                }
            }

            $prepared[] = $node;
        }

        $components->replace(new ThemeComponent(
            new ComponentId('nodes'),
            new NodesComponent(new NodeCollection($prepared)),
        ));
    }

    private function prepareFunctions(
        ThemeComponentCollection $components,
        string $root,
        string $architecture,
        bool $strict,
        DiagnosticsService $diagnostics,
    ): void {
        $component = $this->component($components, 'functions', FunctionsComponent::class);
        if ($component === null) {
            return;
        }

        $remaining = [];
        foreach ($component->functions() as $function) {
            $resource = $function->resource();
            if ($resource === null) {
                $remaining[] = $function;
                continue;
            }

            $extension = $architecture === 'classic' ? '.classic.php' : '.block.html';
            $path = $this->join($root, 'functions', $resource, $resource . $extension);

            if (!is_file($path)) {
                $this->reportUnavailable(
                    strict: $strict,
                    diagnostics: $diagnostics,
                    type: 'function-resource',
                    id: $function->id(),
                    message: sprintf('Function "%s" was excluded; resource file "%s" is missing.', $function->id(), $path),
                    metadata: ['function_id' => $function->id(), 'resource' => $resource, 'missing_files' => [$path]],
                );
                continue;
            }

            $remaining[] = $function;
        }

        $components->replace(new ThemeComponent(
            new ComponentId('functions'),
            new FunctionsComponent(new FunctionComponentCollection($remaining)),
        ));
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T|null
     */
    private function component(
        ThemeComponentCollection $components,
        string $id,
        string $class,
    ): ?object {
        $themeComponent = $components->find(new ComponentId($id));
        if ($themeComponent === null) {
            return null;
        }

        $component = $themeComponent->component();
        if (!$component instanceof $class) {
            throw new RuntimeException(sprintf('Theme component "%s" must be an instance of %s.', $id, $class));
        }

        return $component;
    }

    private function copyNode(
        Node $node,
        ?string $resource,
        ?FunctionDefinition $function,
        bool $resourceSkipped,
    ): Node {
        return new Node(
            id: $node->id(),
            type: $node->type(),
            resource: $resource,
            name: $node->name(),
            strategy: $node->strategy(),
            description: $node->description(),
            capabilities: $node->capabilities(),
            metadata: $node->metadata(),
            function: $function,
            rendering: $node->rendering(),
            resourceSkipped: $resourceSkipped,
        );
    }

    private function assetFunctionPath(string $root, Asset $asset, string $architecture): string
    {
        $extension = $architecture === 'classic' ? 'function.classic.php' : 'function.block.html';
        return $this->join($root, 'assets', $asset->type()->value, $asset->id(), $architecture, $extension);
    }

    private function join(string ...$segments): string
    {
        $path = array_shift($segments) ?? '';
        foreach ($segments as $segment) {
            $path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR
                . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, trim($segment, '/\\'));
        }
        return $path;
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function reportUnavailable(
        bool $strict,
        DiagnosticsService $diagnostics,
        string $type,
        string $id,
        string $message,
        array $metadata,
    ): void {
        $diagnostics->create(
            $strict ? DiagnosticLevel::ERROR : DiagnosticLevel::WARNING,
            $message,
            new DiagnosticContext(['resource_type' => $type, 'resource_id' => $id] + $metadata),
            $metadata,
        );

        if ($strict) {
            throw new RuntimeException($message);
        }
    }
}
