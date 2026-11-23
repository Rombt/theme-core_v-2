<?php

declare(strict_types=1);

namespace Tests\Unit\ThemeConfiguration;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistration;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistry;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsValidator;
use Rombt\ThemeCore\ThemeConfiguration\PackageId;
use Rombt\ThemeCore\ThemeConfiguration\PackageLoader;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemePackageInterface;

final class PackageLoaderTest extends TestCase
{
    public function testValidatesEachLoadedDomainUsingItsRegisteredValidator(): void
    {
        $packagePath = $this->createPackageFile(<<<'PHP'
<?php
return [
    'scripts' => [
        'app' => [
            'type' => 'script',
            'resource' => ['path' => 'src', 'files' => ['app.js']],
            'dest_path' => 'assets/js/app.js',
        ],
    ],
];
PHP);

        try {
            $package = $this->package($packagePath);
            $loader = $this->loader();

            $loaded = $loader->load($package);

            self::assertInstanceOf(
                AssetsConfiguration::class,
                $loaded->domains()->get(new DomainId('assets'))->configuration(),
            );
        } finally {
            unlink($packagePath);
        }
    }

    public function testRejectsInvalidDomainDuringPackageLoading(): void
    {
        $packagePath = $this->createPackageFile(<<<'PHP'
<?php
return [
    'scripts' => [
        'app' => [
            'type' => 'script',
            'resource' => ['path' => 'src', 'files' => ['app.js']],
            'dest_path' => '../outside.js',
        ],
    ],
];
PHP);

        try {
            $this->expectException(RuntimeException::class);
            $this->expectExceptionMessage('must have a valid relative POSIX destination path');

            $this->loader()->load($this->package($packagePath));
        } finally {
            unlink($packagePath);
        }
    }

    public function testRejectsUnsupportedPackageArchitectureBeforeLoadingDomains(): void
    {
        $packagePath = $this->createPackageFile('<?php return [];');

        try {
            $package = new class($packagePath) implements ThemePackageInterface {
                public function __construct(private readonly string $path)
                {
                }

                public function id(): PackageId
                {
                    return new PackageId('invalid-package');
                }

                public function path(): string
                {
                    return dirname($this->path);
                }

                public function configuration(): array
                {
                    return [
                        'architectures' => ['gutenberg'],
                        'domains' => ['assets' => basename($this->path)],
                    ];
                }
            };

            $this->expectException(RuntimeException::class);
            $this->expectExceptionMessage('declares an unsupported architecture "gutenberg"');

            $this->loader()->load($package);
        } finally {
            unlink($packagePath);
        }
    }


    public function testRejectsPackageDeclaringMultipleArchitectures(): void
    {
        $packagePath = $this->createPackageFile('<?php return [];');

        try {
            $package = new class($packagePath) implements ThemePackageInterface {
                public function __construct(private readonly string $path) {}
                public function id(): PackageId { return new PackageId('multi-architecture-package'); }
                public function path(): string { return dirname($this->path); }
                public function configuration(): array
                {
                    return ['architectures' => ['classic', 'block'], 'domains' => []];
                }
            };

            $this->expectException(RuntimeException::class);
            $this->expectExceptionMessage('must declare exactly one supported architecture');
            $this->loader()->load($package);
        } finally {
            unlink($packagePath);
        }
    }

    public function testRejectsPackageWithoutArchitectureDeclaration(): void
    {
        $packagePath = $this->createPackageFile('<?php return [];');

        try {
            $package = new class($packagePath) implements ThemePackageInterface {
                public function __construct(private readonly string $path) {}
                public function id(): PackageId { return new PackageId('missing-architecture-package'); }
                public function path(): string { return dirname($this->path); }
                public function configuration(): array { return ['domains' => []]; }
            };

            $this->expectException(RuntimeException::class);
            $this->expectExceptionMessage('must declare exactly one supported architecture');
            $this->loader()->load($package);
        } finally {
            unlink($packagePath);
        }
    }

    private function loader(): PackageLoader
    {
        $registration = new DomainRegistration(
            id: new DomainId('assets'),
            domainClass: AssetsConfiguration::class,
            validator: new AssetsValidator(),
        );

        return new PackageLoader(
            new DomainRegistry(['assets' => $registration]),
        );
    }

    private function package(string $domainFile): ThemePackageInterface
    {
        return new class($domainFile) implements ThemePackageInterface {
            public function __construct(private readonly string $domainFile)
            {
            }

            public function id(): PackageId
            {
                return new PackageId('test-package');
            }

            public function path(): string
            {
                return dirname($this->domainFile);
            }

            public function configuration(): array
            {
                return [
                    'architectures' => ['classic'],
                    'domains' => ['assets' => basename($this->domainFile)],
                ];
            }
        };
    }

    private function createPackageFile(string $contents): string
    {
        $path = tempnam(sys_get_temp_dir(), 'theme-core-assets-');

        if ($path === false) {
            throw new RuntimeException('Unable to create temporary package domain file.');
        }

        file_put_contents($path, $contents);

        return $path;
    }
}
