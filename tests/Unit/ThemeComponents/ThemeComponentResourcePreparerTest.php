<?php

declare(strict_types=1);

namespace Tests\Unit\ThemeComponents;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticCollector;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportBuilder;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetResource;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetResourceFile;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetsComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Assets\AssetType;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Node;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodeCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodesComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\NodeType;
use Rombt\ThemeCore\ThemeComponents\Domains\Rendering\Rendering;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Composition;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionType;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionComponent;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionComponentCollection;
use Rombt\ThemeCore\ThemeComponents\Domains\Functions\FunctionsComponent;
use Rombt\ThemeCore\ThemeComponents\Preparation\ThemeComponentResourcePreparer;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use RuntimeException;

final class ThemeComponentResourcePreparerTest extends TestCase
{
    private string $resourceRoot;

    protected function setUp(): void
    {
        $this->resourceRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'theme-core-resource-preparer-' . bin2hex(random_bytes(5));
        mkdir($this->resourceRoot, 0777, true);
    }

    protected function tearDown(): void
    {
        $this->removeDirectory($this->resourceRoot);
    }

    public function testSoftModeExcludesMissingAssetAndAllTransitiveDependants(): void
    {
        $this->createAssetFile('healthy', 'style.css');
        $this->createAssetFile('dependent', 'style.css');
        $this->createAssetFile('dependent-two', 'style.css');

        $components = $this->assetComponents([
            $this->asset('missing', ['missing.css']),
            $this->asset('dependent', ['style.css'], ['missing']),
            $this->asset('dependent-two', ['style.css'], ['dependent']),
            $this->asset('healthy', ['style.css']),
        ]);
        $diagnostics = $this->diagnostics();

        (new ThemeComponentResourcePreparer())->prepare(
            $components,
            $this->resourceRoot,
            'classic',
            false,
            $diagnostics,
        );

        $assets = $components->find(new ComponentId('assets'))->component()->assets()->all();

        self::assertSame(['healthy'], array_map(static fn (Asset $asset): string => $asset->id(), $assets));
        self::assertSame(3, $diagnostics->report()->severities()[DiagnosticLevel::WARNING->value]);

        $messages = array_map(
            static fn ($entry): string => $entry->message(),
            $diagnostics->report()->entries(),
        );
        self::assertStringContainsString('depends on excluded asset(s): missing', $messages[1]);
        self::assertStringContainsString('depends on excluded asset(s): dependent', $messages[2]);
    }

    public function testSoftModeGroupsAllMissingFilesIntoOneWarningPerAsset(): void
    {
        $components = $this->assetComponents([
            $this->asset('multi-file', ['first.css', 'second.css']),
        ]);
        $diagnostics = $this->diagnostics();

        (new ThemeComponentResourcePreparer())->prepare(
            $components,
            $this->resourceRoot,
            'classic',
            false,
            $diagnostics,
        );

        $entries = $diagnostics->report()->entries();
        self::assertCount(1, $entries);
        self::assertSame(DiagnosticLevel::WARNING, $entries[0]->level());
        self::assertCount(2, $entries[0]->metadata()['missing_files']);
    }

    public function testSoftModeMarksMissingNodeAndCompositionResourcesAsSkipped(): void
    {
        $node = new Node(
            id: 'missing-node',
            type: new NodeType('common'),
            resource: 'missing-node-resource',
            name: 'Missing Node',
            rendering: Rendering::Inline,
        );
        $composition = new Composition(
            id: 'missing-composition',
            type: new CompositionType('layout'),
            resource: 'missing-composition-resource',
            rendering: Rendering::Inline,
        );
        $components = new ThemeComponentCollection([
            new ThemeComponent(
                new ComponentId('nodes'),
                new NodesComponent(new NodeCollection([$node])),
            ),
            new ThemeComponent(
                new ComponentId('compositions'),
                new CompositionsComponent(new CompositionCollection([$composition])),
            ),
        ]);
        $diagnostics = $this->diagnostics();

        (new ThemeComponentResourcePreparer())->prepare(
            $components,
            $this->resourceRoot,
            'classic',
            false,
            $diagnostics,
        );

        $preparedNode = $components->find(new ComponentId('nodes'))->component()->nodes()->find('missing-node');
        $preparedComposition = $components->find(new ComponentId('compositions'))->component()->compositions()->find('missing-composition');

        self::assertNull($preparedNode->resource());
        self::assertTrue($preparedNode->resourceSkipped());
        self::assertNull($preparedComposition->resource());
        self::assertTrue($preparedComposition->resourceSkipped());
        self::assertSame(2, $diagnostics->report()->severities()[DiagnosticLevel::WARNING->value]);
    }

    public function testSoftModeExcludesStandaloneFunctionWithMissingSource(): void
    {
        $function = new FunctionComponent(
            id: 'custom-function',
            type: 'hook',
            resource: 'custom-function',
            name: 'Custom Function',
            description: null,
        );
        $components = new ThemeComponentCollection([
            new ThemeComponent(
                new ComponentId('functions'),
                new FunctionsComponent(new FunctionComponentCollection([$function])),
            ),
        ]);
        $diagnostics = $this->diagnostics();

        (new ThemeComponentResourcePreparer())->prepare(
            $components,
            $this->resourceRoot,
            'classic',
            false,
            $diagnostics,
        );

        $functions = $components->find(new ComponentId('functions'))->component()->functions();
        self::assertCount(0, $functions);
        self::assertSame(1, $diagnostics->report()->severities()[DiagnosticLevel::WARNING->value]);
    }

    public function testStrictModeReportsErrorAndStopsPreparation(): void
    {
        $components = $this->assetComponents([
            $this->asset('missing', ['missing.css']),
        ]);
        $diagnostics = $this->diagnostics();

        try {
            (new ThemeComponentResourcePreparer())->prepare(
                $components,
                $this->resourceRoot,
                'classic',
                true,
                $diagnostics,
            );
            self::fail('Expected a missing resource to stop strict build preparation.');
        } catch (RuntimeException $exception) {
            self::assertStringContainsString('Asset "missing" was excluded', $exception->getMessage());
        }

        self::assertSame(1, $diagnostics->report()->severities()[DiagnosticLevel::ERROR->value]);
    }

    /** @param list<Asset> $assets */
    private function assetComponents(array $assets): ThemeComponentCollection
    {
        return new ThemeComponentCollection([
            new ThemeComponent(
                new ComponentId('assets'),
                new AssetsComponent(new AssetCollection($assets)),
            ),
        ]);
    }

    /** @param list<string> $files @param list<string> $dependencies */
    private function asset(string $id, array $files, array $dependencies = []): Asset
    {
        return new Asset(
            id: $id,
            name: $id,
            type: AssetType::Style,
            resource: new AssetResource(
                'assets/style/' . $id,
                array_map(static fn (string $file): AssetResourceFile => new AssetResourceFile($file), $files),
            ),
            destPath: 'assets/' . $id . '.css',
            dependencies: $dependencies,
        );
    }

    private function createAssetFile(string $id, string $filename): void
    {
        $directory = $this->resourceRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'style' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'classic';
        mkdir($directory, 0777, true);
        file_put_contents($directory . DIRECTORY_SEPARATOR . $filename, '/* test */');
    }

    private function diagnostics(): DiagnosticsService
    {
        return new DiagnosticsService(
            new DiagnosticCollector(),
            new DiagnosticReportBuilder(),
        );
    }

    private function removeDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }

        foreach (new \FilesystemIterator($directory) as $item) {
            if ($item->isDir() && !$item->isLink()) {
                $this->removeDirectory($item->getPathname());
                continue;
            }

            unlink($item->getPathname());
        }

        rmdir($directory);
    }
}
