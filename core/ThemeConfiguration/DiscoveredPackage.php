<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final readonly class DiscoveredPackage
{
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

    public function configuration(): array
    {
        return $this->configuration;
    }

    public function metadata(): PackageMetadata
    {
        return new PackageMetadata(
            name: (string) ($this->configuration['name'] ?? ''),
            version: (string) ($this->configuration['version'] ?? ''),
        );
    }

    public function path(): string
    {
        return $this->path;
    }
}
