<?php

declare(strict_types=1);

namespace Tests\Unit\Artifacts\Assets;

use LogicException;
use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Artifacts\Assets\AssetPathResolver;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Asset;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\Resource;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ResourceFile;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\AssetType;

final class AssetPathResolverTest extends TestCase
{
    public function testUsesAssetDestinationAsAnExactFilePath(): void
    {
        $asset = new Asset(
            id: 'theme-style',
            name: 'Theme Styles',
            type: AssetType::Style,
            resource: new Resource(
                path: 'assets/css',
                files: [new ResourceFile('style.css')],
            ),
            destPath: 'assets/css/theme.css',
        );

        self::assertSame(
            'assets/css/theme.css',
            (new AssetPathResolver())->destination(
                $asset,
                $asset->resource()->files()[0],
            ),
        );
    }

    public function testUsesPerFileDestinationForMultiFileAssets(): void
    {
        $asset = new Asset(
            id: 'primary-font',
            name: 'Primary Font',
            type: AssetType::Font,
            resource: new Resource(
                path: 'assets/fonts',
                files: [
                    new ResourceFile(
                        'regular.woff2',
                        'assets/fonts/inter/regular.woff2',
                    ),
                    new ResourceFile(
                        'italic.woff2',
                        'assets/fonts/inter/italic.woff2',
                    ),
                ],
            ),
            destPath: '',
        );

        $resolver = new AssetPathResolver();
        $files = $asset->resource()->files();

        self::assertSame(
            'assets/fonts/inter/regular.woff2',
            $resolver->destination($asset, $files[0]),
        );
        self::assertSame(
            'assets/fonts/inter/italic.woff2',
            $resolver->destination($asset, $files[1]),
        );
    }

    public function testThrowsWhenNoDestinationIsAvailable(): void
    {
        $asset = new Asset(
            id: 'missing-destination',
            name: 'Missing Destination',
            type: AssetType::Image,
            resource: new Resource(
                path: 'assets/images',
                files: [new ResourceFile('logo.svg')],
            ),
            destPath: '',
        );

        $this->expectException(LogicException::class);

        (new AssetPathResolver())->destination(
            $asset,
            $asset->resource()->files()[0],
        );
    }
}
