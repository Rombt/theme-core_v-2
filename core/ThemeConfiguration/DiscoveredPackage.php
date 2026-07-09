<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemePackageInterface;

final readonly class DiscoveredPackage implements ThemePackageInterface
{
    /**
     * @param array<string, mixed> $configuration
     */
    public function __construct(
        private PackageId $id,
        private array $configuration,
        private string $path,
    ) {
    }

    public function id(): PackageId
    {
        return $this->id;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function configuration(): array
    {
        return $this->configuration;
    }
}
