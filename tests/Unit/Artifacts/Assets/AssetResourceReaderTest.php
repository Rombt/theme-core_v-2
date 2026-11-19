<?php

declare(strict_types=1);

namespace Tests\Unit\Artifacts\Assets;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\ApplicationContext;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Assets\AssetResourceReader;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Resource;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ResourceFile;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\AssetType;

final class AssetResourceReaderTest extends TestCase
{
    private string $resourcePackage;

    protected function setUp(): void
    {
        $this->resourcePackage = sys_get_temp_dir()
            . DIRECTORY_SEPARATOR
            . 'theme-core-asset-reader-'
            . bin2hex(random_bytes(8));

        mkdir($this->resourcePackage, 0777, true);
    }

    protected function tearDown(): void
    {
        $this->removeDirectory($this->resourcePackage);
    }

    public function testReadsResourceFileFromResourcePathAndSelectedArchitecture(): void
    {
        $this->writeResource(
            'assets/custom/theme/classic/theme.css',
            'classic css',
        );
        $this->writeResource(
            'assets/custom/theme/block/theme.css',
            'block css',
        );

        $asset = new Asset(
            id: 'logical-theme-style',
            name: 'Theme Styles',
            type: AssetType::Style,
            resource: new Resource(
                path: 'assets/custom/theme',
                files: [new ResourceFile('theme.css')],
            ),
            destPath: 'assets/css/theme.css',
        );

        self::assertSame(
            'classic css',
            $this->reader('classic')->read($asset, $asset->resource()->files()[0]),
        );
        self::assertSame(
            'block css',
            $this->reader('block')->read($asset, $asset->resource()->files()[0]),
        );
    }

    public function testDoesNotDeriveResourceDirectoryFromAssetTypeOrId(): void
    {
        $this->writeResource(
            'assets/custom/location/classic/custom.css',
            'custom resource',
        );

        $asset = new Asset(
            id: 'asset-id-is-not-a-directory',
            name: 'Custom Asset',
            type: AssetType::Style,
            resource: new Resource(
                path: 'assets/custom/location',
                files: [new ResourceFile('custom.css')],
            ),
            destPath: 'custom.css',
        );

        self::assertSame(
            'custom resource',
            $this->reader('classic')->read($asset, $asset->resource()->files()[0]),
        );
    }

    private function reader(string $architecture): AssetResourceReader
    {
        $configuration = new class($this->resourcePackage) implements ConfigurationInterface {
            public function __construct(private readonly string $resourcePackage)
            {
            }

            public function get(string $key): mixed
            {
                return $key === 'theme.resource_package'
                    ? $this->resourcePackage
                    : null;
            }

            public function all(): array
            {
                return ['theme.resource_package' => $this->resourcePackage];
            }
        };

        $app = new Application();
        $app->setContext(new ApplicationContext([
            ApplicationContextKeys::CONFIGURATION => $configuration,
        ]));

        return new AssetResourceReader($app, $architecture);
    }

    private function writeResource(string $relativePath, string $content): void
    {
        $path = $this->resourcePackage
            . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
        $directory = dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, $content);
    }

    private function removeDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }

        $items = new \FilesystemIterator($directory);
        foreach ($items as $item) {
            if ($item->isDir() && !$item->isLink()) {
                $this->removeDirectory($item->getPathname());
                continue;
            }

            unlink($item->getPathname());
        }

        rmdir($directory);
    }
}
