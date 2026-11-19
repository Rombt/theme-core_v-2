<?php

declare(strict_types=1);

namespace Tests\Unit\ThemeConfiguration\Domains\Assets;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsValidator;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\Definitions\FunctionDefinition;

final class AssetsValidatorTest extends TestCase
{
    public function testAcceptsSingleFileAssetWithAssetLevelDestination(): void
    {
        self::expectNotToPerformAssertions();

        $this->validate([
            'app' => $this->asset(
                resource: ['path' => 'src', 'files' => ['app.js']],
                destPath: 'assets/js/app.js',
            ),
        ]);
    }

    public function testAcceptsMultiFileAssetWithPerFileDestinations(): void
    {
        self::expectNotToPerformAssertions();

        $this->validate([
            'bundle' => $this->asset(
                resource: [
                    'path' => 'src',
                    'files' => [
                        ['path' => 'one.js', 'dest_path' => 'assets/js/one.js'],
                        ['path' => 'two.js', 'dest_path' => 'assets/js/two.js'],
                    ],
                ],
            ),
        ]);
    }

    public function testDoesNotRevalidateResourceBasePathOrDependencies(): void
    {
        self::expectNotToPerformAssertions();

        $this->validate([
            'app' => $this->asset(
                resource: ['path' => '', 'files' => ['app.js']],
                destPath: 'assets/js/app.js',
                dependencies: ['dependency-resolution-owns-this-check'],
            ),
        ]);
    }

    public function testRejectsBlankAssetId(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Asset ID must not be empty.');

        $this->validate(['   ' => $this->asset()]);
    }

    public function testRejectsDuplicateAssetIdsAcrossGroups(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Duplicate asset ID "app".');

        $this->validate([
            'app' => $this->asset(destPath: 'assets/js/app.js'),
        ], [
            'app' => $this->asset(destPath: 'assets/js/other.js'),
        ]);
    }

    public function testRejectsBlankAssetType(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Asset "app" must have a type.');

        $this->validate([
            'app' => $this->asset(type: '  ', destPath: 'assets/js/app.js'),
        ]);
    }

    public function testAcceptsEverySupportedAssetType(): void
    {
        self::expectNotToPerformAssertions();

        $assets = [];

        foreach (['style', 'script', 'font', 'image'] as $index => $type) {
            $assets[$type] = $this->asset(
                type: $type,
                destPath: sprintf('assets/%d.%s', $index, $type),
            );
        }

        $this->validate($assets);
    }

    public function testRejectsUnsupportedAssetType(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Asset "app" has unsupported type "video".');

        $this->validate([
            'app' => $this->asset(type: 'video', destPath: 'assets/app.mp4'),
        ]);
    }

    public function testRejectsAssetsWithoutResourceFiles(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('must contain at least one resource file');

        $this->validate([
            'app' => $this->asset(resource: ['path' => 'src', 'files' => []]),
        ]);
    }

    public function testRejectsBlankResourceFilePath(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Resource file path for asset "app" must not be empty.');

        $this->validate([
            'app' => $this->asset(
                resource: ['path' => 'src', 'files' => ['  ']],
                destPath: 'assets/js/app.js',
            ),
        ]);
    }

    #[DataProvider('invalidDestinationPaths')]
    public function testRejectsInvalidDestinationPaths(string $destination): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('must have a valid relative POSIX destination path');

        $this->validate([
            'app' => $this->asset(destPath: $destination),
        ]);
    }

    public static function invalidDestinationPaths(): iterable
    {
        yield 'empty' => [''];
        yield 'whitespace' => ['   '];
        yield 'leading whitespace' => [' assets/app.js'];
        yield 'absolute POSIX' => ['/assets/app.js'];
        yield 'Windows drive' => ['C:/assets/app.js'];
        yield 'backslash' => ['assets\\app.js'];
        yield 'parent traversal' => ['assets/../app.js'];
        yield 'current directory segment' => ['assets/./app.js'];
        yield 'duplicate separator' => ['assets//app.js'];
        yield 'trailing separator' => ['assets/app.js/'];
        yield 'null byte' => ["assets/\0app.js"];
    }

    public function testRejectsDuplicateDestinationsAcrossAssets(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Duplicate asset destination path');

        $this->validate([
            'first' => $this->asset(destPath: 'assets/js/app.js'),
            'second' => $this->asset(destPath: 'assets/js/app.js'),
        ]);
    }

    public function testRejectsCaseInsensitiveDestinationCollision(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Duplicate asset destination path');

        $this->validate([
            'first' => $this->asset(destPath: 'assets/js/app.js'),
            'second' => $this->asset(destPath: 'Assets/JS/App.js'),
        ]);
    }

    public function testRejectsDestinationDefinedOnBothAssetAndSingleResourceFile(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('must define destination either on the asset or on its resource file');

        $this->validate([
            'app' => $this->asset(
                resource: [
                    'path' => 'src',
                    'files' => [
                        ['path' => 'app.js', 'dest_path' => 'assets/js/app.js'],
                    ],
                ],
                destPath: 'assets/js/other.js',
            ),
        ]);
    }

    public function testRejectsAssetLevelDestinationForMultiFileAsset(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('must define dest_path on each resource file');

        $this->validate([
            'bundle' => $this->asset(
                resource: ['path' => 'src', 'files' => ['one.js', 'two.js']],
                destPath: 'assets/js/bundle.js',
            ),
        ]);
    }

    public function testRejectsInvalidFunctionOrder(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Function order for asset "app" must be between 0 and 100.');

        $this->validate([
            'app' => $this->asset(
                destPath: 'assets/js/app.js',
                function: ['enabled' => true, 'order' => 101],
            ),
        ]);
    }

    /**
     * @param array<string, array<string, mixed>> ...$groups
     */
    private function validate(array ...$groups): void
    {
        $assets = [];

        foreach ($groups as $index => $group) {
            $assets['group-' . $index] = $group;
        }

        $configuration = new AssetsConfiguration($assets);
        $domain = new ConfigurationDomain(
            new DomainId('assets'),
            $configuration,
        );

        (new AssetsValidator())->validate($domain);
    }

    /**
     * @param array<string, mixed>|null $resource
     * @param array<string, mixed>|null $function
     * @param list<string> $dependencies
     * @return array<string, mixed>
     */
    private function asset(
        string $type = 'script',
        ?array $resource = null,
        string $destPath = '',
        array $dependencies = [],
        ?array $function = null,
    ): array {
        return [
            'type' => $type,
            'resource' => $resource ?? ['path' => 'src', 'files' => ['app.js']],
            'dest_path' => $destPath,
            'dependencies' => $dependencies,
            'function' => $function,
        ];
    }
}
