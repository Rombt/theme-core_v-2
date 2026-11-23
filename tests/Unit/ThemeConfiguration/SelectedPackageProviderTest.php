<?php

declare(strict_types=1);

namespace Tests\Unit\ThemeConfiguration;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageSelectorInterface;
use Rombt\ThemeCore\ThemeConfiguration\PackageId;
use Rombt\ThemeCore\ThemeConfiguration\SelectedPackage;
use Rombt\ThemeCore\ThemeConfiguration\SelectedPackageProvider;
use Rombt\ThemeCore\ThemeConfiguration\ThemeArchitecture;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistration;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemePackageInterface;

final class SelectedPackageProviderTest extends TestCase
{
    public function testResolvesClassicArchitectureFromPackageMetadata(): void
    {
        $provider = $this->provider(['classic']);

        self::assertSame(ThemeArchitecture::Classic, $provider->architecture());
    }

    public function testResolvesBlockArchitectureFromPackageMetadata(): void
    {
        $provider = $this->provider(['block']);

        self::assertSame(ThemeArchitecture::Block, $provider->architecture());
    }

    public function testRejectsPackageDeclaringMultipleArchitectures(): void
    {
        $provider = $this->provider(['classic', 'block']);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('must declare exactly one supported architecture');

        $provider->architecture();
    }

    public function testRejectsUnknownPackageArchitecture(): void
    {
        $provider = $this->provider(['gutenberg']);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('declares unsupported architecture "gutenberg"');

        $provider->architecture();
    }

    private function provider(array $architectures): SelectedPackageProvider
    {
        $package = new class($architectures) implements ThemePackageInterface {
            public function __construct(private readonly array $architectures) {}
            public function id(): PackageId { return new PackageId('test-package'); }
            public function path(): string { return sys_get_temp_dir(); }
            public function configuration(): array { return ['architectures' => $this->architectures]; }
        };

        $selector = $this->createMock(PackageSelectorInterface::class);
        $selector->expects(self::once())
            ->method('select')
            ->with(self::callback(static fn (PackageId $id): bool => $id->value() === 'test-package'))
            ->willReturn(new SelectedPackage(new ThemePackageRegistration($package)));

        $configuration = new class implements ConfigurationInterface {
            public function get(string $key): mixed
            {
                return $key === 'theme.package' ? 'test-package' : null;
            }
            public function all(): array { return ['theme' => ['package' => 'test-package']]; }
        };

        return new SelectedPackageProvider(
            $configuration,
            $selector,
            $this->createMock(PackageLoaderInterface::class),
        );
    }
}
