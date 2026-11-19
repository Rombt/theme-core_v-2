<?php

declare(strict_types=1);

namespace Tests\Unit\ThemeIR\Domains\Assets;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticCollector;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportBuilder;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\Asset as ComponentAsset;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetCollection as ComponentAssetCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetResource;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType as ComponentAssetType;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\AssetIr;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\AssetsThemeIrResolver;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Exceptions\AssetDependencyResolutionException;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\AssetType;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\ResolvedAssetDependency;

final class AssetsThemeIrResolverTest extends TestCase
{
    public function testResolvesDependenciesToExistingAssetsAndPreservesOrder(): void
    {
        $ir = $this->resolver()->resolve($this->components([
            $this->asset('app', ComponentAssetType::Script, ['vendor', 'polyfills']),
            $this->asset('vendor', ComponentAssetType::Script),
            $this->asset('polyfills', ComponentAssetType::Script),
        ]));

        self::assertInstanceOf(AssetIr::class, $ir);
        $asset = $ir->assets()->find('app');
        self::assertNotNull($asset);
        $dependencies = $asset->dependencies();

        self::assertCount(2, $dependencies);
        self::assertSame(['vendor', 'polyfills'], array_map(
            static fn (ResolvedAssetDependency $dependency): string => $dependency->assetId(),
            $dependencies,
        ));
        self::assertSame(AssetType::Script, $dependencies[0]->type());
    }

    public function testAllowsStyleToStyleDependencies(): void
    {
        $ir = $this->resolver()->resolve($this->components([
            $this->asset('theme', ComponentAssetType::Style, ['base']),
            $this->asset('base', ComponentAssetType::Style),
        ]));

        $asset = $ir->assets()->find('theme');
        self::assertNotNull($asset);
        self::assertSame('base', $asset->dependencies()[0]->assetId());
        self::assertSame(AssetType::Style, $asset->dependencies()[0]->type());
    }

    public function testRemovesDuplicateDependenciesAndRecordsWarning(): void
    {
        $diagnostics = $this->diagnostics();
        $ir = (new AssetsThemeIrResolver($diagnostics))->resolve($this->components([
            $this->asset('app', ComponentAssetType::Script, ['vendor', 'vendor']),
            $this->asset('vendor', ComponentAssetType::Script),
        ]));

        $asset = $ir->assets()->find('app');
        self::assertNotNull($asset);
        self::assertCount(1, $asset->dependencies());
        self::assertCount(1, $diagnostics->collector()->entries());
        self::assertSame(DiagnosticLevel::WARNING, $diagnostics->collector()->entries()[0]->level());
        self::assertStringContainsString('Duplicate dependencies', $diagnostics->collector()->entries()[0]->message());
    }

    public function testRejectsSelfDependency(): void
    {
        $this->expectException(AssetDependencyResolutionException::class);
        $this->expectExceptionMessage('cannot depend on itself');

        $this->resolver()->resolve($this->components([
            $this->asset('app', ComponentAssetType::Script, ['app']),
        ]));
    }

    public function testRejectsMissingDependencyAndReportsBothIds(): void
    {
        $this->expectException(AssetDependencyResolutionException::class);
        $this->expectExceptionMessage('Asset "app" depends on missing asset "missing"');

        $this->resolver()->resolve($this->components([
            $this->asset('app', ComponentAssetType::Script, ['missing']),
        ]));
    }

    public function testRejectsCircularDependenciesAndIncludesCyclePath(): void
    {
        $this->expectException(AssetDependencyResolutionException::class);
        $this->expectExceptionMessage('a → b → c → a');

        $this->resolver()->resolve($this->components([
            $this->asset('a', ComponentAssetType::Script, ['b']),
            $this->asset('b', ComponentAssetType::Script, ['c']),
            $this->asset('c', ComponentAssetType::Script, ['a']),
        ]));
    }

    public function testRejectsIncompatibleAssetTypes(): void
    {
        $this->expectException(AssetDependencyResolutionException::class);
        $this->expectExceptionMessage('Only Script-to-Script and Style-to-Style dependencies are supported');

        $this->resolver()->resolve($this->components([
            $this->asset('script', ComponentAssetType::Script, ['style']),
            $this->asset('style', ComponentAssetType::Style),
        ]));
    }

    public function testRejectsDuplicateAssetIdsBecauseReferencesWouldBeAmbiguous(): void
    {
        $this->expectException(AssetDependencyResolutionException::class);
        $this->expectExceptionMessage('Asset ID "duplicate" is declared more than once');

        $this->resolver()->resolve($this->components([
            $this->asset('duplicate', ComponentAssetType::Script),
            $this->asset('duplicate', ComponentAssetType::Script),
        ]));
    }

    private function resolver(): AssetsThemeIrResolver
    {
        return new AssetsThemeIrResolver($this->diagnostics());
    }

    private function diagnostics(): DiagnosticsService
    {
        return new DiagnosticsService(new DiagnosticCollector(), new DiagnosticReportBuilder());
    }

    /**
     * @param list<ComponentAsset> $assets
     */
    private function components(array $assets): ThemeComponentCollection
    {
        return new ThemeComponentCollection([
            new ThemeComponent(
                new ComponentId('assets'),
                new AssetsComponent(new ComponentAssetCollection($assets)),
            ),
        ]);
    }

    /**
     * @param list<string> $dependencies
     */
    private function asset(
        string $id,
        ComponentAssetType $type,
        array $dependencies = [],
    ): ComponentAsset {
        return new ComponentAsset(
            id: $id,
            name: $id,
            type: $type,
            resource: new AssetResource('assets/' . $id),
            destPath: 'assets/' . $id,
            dependencies: $dependencies,
        );
    }
}
